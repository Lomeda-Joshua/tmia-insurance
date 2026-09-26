<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionsNb;
use Illuminate\Support\Facades\Auth;
use Exception;

class TransactionController extends Controller
{
    /**
     * Retrieve transaction details by Insurance Number.
     */
    public function getByInsuranceNo(Request $request): JsonResponse
    {

        // 1. Request validation handles empty/missing parameter checks
        $validated = $request->validate([
            'insuranceNo' => ['nullable', 'string'],
        ]);

        // 2. Query builder replaces manual PDO connection instantiation
        $transactions = DB::table('transactions_rb')
            ->where('Insurance_No', $validated['insuranceNo'])
            ->get();

        // 3. Return structured JSON response
        return response()->json($transactions);
    }



    /**
     * Update transaction net remittance using Eloquent ORM.
     */
    public function updateNetRemittance(Request $request): JsonResponse
    {
        // 1. Validate inputs (replaces manual fallbacks)
        $validatedData = $request->validate([
            'insuranceno'   => 'required|string',
            'insgpremium'   => 'nullable|numeric',
            'netrem'        => 'nullable|numeric',
            'inscommission' => 'nullable|numeric',
        ]);

        try {
            // 2. Wrap operations inside Eloquent/DB Transaction
            return DB::transaction(function () use ($validatedData) {

                // 3. Perform Eloquent update directly by condition
                $affectedRows = TransactionsNb::where('Insurance_No', $validatedData['insuranceno'])
                    ->update([
                        'Gross_Premium' => $validatedData['insgpremium'] ?? null,
                        'Net_Rem'       => $validatedData['netrem'] ?? null,
                        'Net_Rem_Date'  => now(),
                        'Commission'    => $validatedData['inscommission'] ?? null,
                        'User_ID'       => Auth::id(),
                    ]);

                // Optional check if the record actually existed
                if ($affectedRows === 0) {
                    return response()->json([
                        'result'  => 0,
                        'message' => 'No transaction found matching that Insurance No.',
                    ], 404);
                }

                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $validatedData['insuranceno'],
                ]);
            });

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }

}
