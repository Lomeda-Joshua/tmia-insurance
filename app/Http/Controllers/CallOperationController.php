<?php

namespace App\Http\Controllers;

use App\Models\TransactionRbCallLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CallLogRb;
use App\Models\CallReason;
use App\Models\VwCallLogsRb;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class CallOperationController extends Controller
{
    /**
     * Get the latest call log for a specific insurance number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLatestCallLog(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceno' => 'required|string',
        ]);

        // 2. Fetch latest log entry using Query Builder joins
        $data = TransactionRbCallLog::query()
            ->from('transactions_rb_call_logs as cl')
            ->leftJoin('communication_type as cm', 'cl.Communication_ID', '=', 'cm.Communication_ID')
            ->leftJoin('call_status_type as cs', 'cl.Call_SID', '=', 'cs.Call_SID')
            ->leftJoin('call_reason as cr', 'cl.Reason_ID', '=', 'cr.Reason_ID')
            ->where('cl.Insurance_No', $validated['insuranceno'])
            ->select([
                'cl.Insurance_No',
                'cl.Communication_ID',
                'cm.Communication_Type',
                'cl.Call_SID',
                'cs.Call_Status',
                'cl.Reason_ID',
                'cr.Reason_Desc',
                'cl.Promised_Pay_Date',
                'cl.Call_Remarks',
            ])
            ->orderBy('cl.Call_logID', 'desc')
            ->first();

        // 3. Return JSON response (Returns empty array if no record found to match original behavior)
        return response()->json($data ? [$data] : []);
    }


    /**
     * Fetch call logs for a given insurance number
     */
    public function getCallLogs(Request $request): JsonResponse
    {
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json(['data' => '']);
        }

        // Fetch logs using Eloquent scope
        $logs = CallLogRb::byInsuranceNo($insuranceNo)->get();

        if ($logs->isNotEmpty()) {
            // Map over collection to inject 'urutan' sequence index
            $data = $logs->values()->map(function ($log, $index) {
                $item = $log->toArray();
                $item['urutan'] = $index + 1;
                return $item;
            });
        } else {
            $data = '';
        }

        return response()->json(['data' => $data]);
    }


    /**
     * Fetch call reasons based on Call_SID.
     */
    public function getCallReasons(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'callsid' => 'required|integer',
        ]);

        $reasons = CallReason::where('Call_SID', $validated['callsid'])
            ->get(['Reason_ID', 'Reason_Desc']);

        return response()->json($reasons);
    }


    /**
     * Store or update the call log history entry.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeCallLog(Request $request): JsonResponse
    {
        // 1. Validation
        $validated = $request->validate([
            'insuranceno'     => 'required|string',
            'commid'          => 'nullable|string',
            'callsid'         => 'nullable|string',
            'callreasonid'    => 'nullable|string',
            'promisedpaydate' => 'nullable|date',
            'callremarks'     => 'nullable|string',
        ]);

        $insuranceNo = $validated['insuranceno'];
        $userId      = Auth::id(); // Replaces $_SESSION['userid']

        try {
            // 2. Wrap database operations inside a transaction
            return DB::transaction(function () use ($validated, $insuranceNo, $userId) {

                // Retrieve the latest call log for this insurance number
                $existing = TransactionRbCallLog::where('Insurance_No', $insuranceNo)
                    ->orderBy('Call_Log_Date', 'desc')
                    ->first();

                if ($existing) {
                    // Check if key routing fields have changed
                    $hasChanges = 
                        (string)$existing->Communication_ID !== (string)($validated['commid'] ?? '') ||
                        (string)$existing->Call_SID          !== (string)($validated['callsid'] ?? '') ||
                        (string)$existing->Reason_ID           !== (string)($validated['callreasonid'] ?? '') ||
                        (string)$existing->User_ID             !== (string)$userId;

                    if ($hasChanges) {
                        // Insert new historical log record
                        TransactionRbCallLog::create([
                            'Insurance_No'      => $insuranceNo,
                            'Communication_ID'  => $validated['commid'] ?? null,
                            'Call_SID'          => $validated['callsid'] ?? null,
                            'Reason_ID'         => $validated['callreasonid'] ?? null,
                            'Promised_Pay_Date' => $validated['promisedpaydate'] ?? null,
                            'Call_Remarks'      => $validated['callremarks'] ?? null,
                            'Call_Log_Date'     => now(),
                            'User_ID'           => $userId,
                        ]);
                    } else {
                        // Update existing record's remarks and timestamp only
                        $existing->update([
                            'Promised_Pay_Date' => $validated['promisedpaydate'] ?? null,
                            'Call_Remarks'      => $validated['callremarks'] ?? null,
                            'Call_Log_Date'     => now(),
                        ]);
                    }
                } else {
                    // First record entry
                    TransactionRbCallLog::create([
                        'Insurance_No'      => $insuranceNo,
                        'Communication_ID'  => $validated['commid'] ?? null,
                        'Call_SID'          => $validated['callsid'] ?? null,
                        'Reason_ID'         => $validated['callreasonid'] ?? null,
                        'Promised_Pay_Date' => $validated['promisedpaydate'] ?? null,
                        'Call_Remarks'      => $validated['callremarks'] ?? null,
                        'Call_Log_Date'     => now(),
                        'User_ID'           => $userId,
                    ]);
                }

                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $insuranceNo,
                ]);
            });

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => 'Something went wrong. Please try again.',
            ], 500);
        }
    }


    /**
     * Fetch all call logs for a specific insurance number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCallLogsByInsuranceNo(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceno' => 'required|string',
        ]);

        // 2. Query view using Eloquent
        $logs = VwCallLogsRb::where('Insurance_No', $validated['insuranceno'])
            ->orderBy('Call_LogID', 'desc')
            ->get();

        // 3. Transform data to add index counter ('urutan')
        if ($logs->isNotEmpty()) {
            $data = $logs->map(function ($row, $index) {
                $rowArray = $row->toArray();
                $rowArray['urutan'] = $index + 1;
                return $rowArray;
            });
        } else {
            $data = ''; // Maintains original string fallback if empty
        }

        // 4. Return formatted JSON response
        return response()->json([
            'data' => $data,
        ]);
    }

    
}
