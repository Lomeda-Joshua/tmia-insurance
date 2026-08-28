<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\InsuranceStaff;
use App\Models\CustomerType;


class OverallDataController extends Controller
{


    /**
     * Fetch insurance staff data for DataTables AJAX.
     */
    public function getInsuranceStaff(): JsonResponse
    {
        $staff = InsuranceStaff::query()
            ->orderBy('ISE_Name')
            ->get([
                'ISE_No',
                'ISE_Name',
            ]);

        return response()->json($staff);
    }

    public function getCustomerType(): JsonResponse
    {
        $customerTypes = CustomerType::query()
            ->orderBy('Customer_Type', 'asc')
            ->get([
                'Customer_TID',
                'Customer_Type',
            ]);

        return response()->json($customerTypes);
    }


    public function customers(CustomerListRequest $request): JsonResponse
    {
        // Customer list.
    }

    public function vehicles(VehicleListRequest $request): JsonResponse
    {
        // Vehicle list for selected customer.
    }

    public function payments(NewBusinessPaymentRequest $request): JsonResponse
    {
        // Payment list.
    }

    public function callLogs(NewBusinessCallLogRequest $request): JsonResponse
    {
        
    }

}
