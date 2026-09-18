<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Retrieve transaction details by Insurance Number.
     */
    public function getByInsuranceNo(Request $request): JsonResponse
    {
        // 1. Request validation handles empty/missing parameter checks
        $validated = $request->validate([
            'insuranceno' => ['required', 'string'],
        ]);

        // 2. Query builder replaces manual PDO connection instantiation
        $transactions = DB::table('transactions_nb')
            ->where('Insurance_No', $validated['insuranceno'])
            ->get();

        // 3. Return structured JSON response
        return response()->json($transactions);
    }

}
