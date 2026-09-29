<?php

namespace App\Http\Controllers;

use App\Models\TransactionRbCallLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class CallEntryController extends Controller
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
}
