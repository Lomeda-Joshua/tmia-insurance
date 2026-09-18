<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VehicleLookupController extends Controller
{
    /**
     * Retrieve customer and vehicle information by VIN.
     */
    public function lookupByVin(Request $request): JsonResponse
    {
        // 1. Validation handles HTTP method implicitly (via routing) 
        // and enforces string structure (standard VIN rules).
        $validated = $request->validate([
            'vin' => ['required', 'string', 'regex:/^[A-Za-z0-9]{17}$/'],
        ]);

        $vin = trim($validated['vin']);

        // 2. Query builder replaces manual PDO connection management
        $vehicle = DB::table('vehicle_information as v')
            ->leftJoin('customer_information as c', 'c.Customer_No', '=', 'v.Customer_No')
            ->select('c.Customer_No', 'c.Full_Name', 'v.Model')
            ->where('v.VIN', $vin)
            ->first();

        // 3. Structured JSON response mapping
        if (!$vehicle) {
            return response()->json([
                'result' => 0,
                'fullname' => null,
                'model' => null,
            ]);
        }

        return response()->json([
            'result' => 1,
            'customerno' => $vehicle->Customer_No,
            'fullname' => $vehicle->Full_Name,
            'model' => $vehicle->Model,
        ]);
    }
}
