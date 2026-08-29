<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\InsuranceStaff;
use App\Models\CustomerType;
use App\Models\UploadedCustomer;
use App\Models\Region;
use App\Models\BodyType;


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

    public function getUploadedCustomer(Request $request){
        $uploadedCustomer = UploadedCustomer::query()
            ->orderBy('Customer_Type', 'asc')
            ->get([
                'Customer_TID',
                'Customer_Type',
            ]);

        return response()->json($uploadedCustomer);
    }

    public function getBodyType(Request $request){
        $uploadedCustomer = BodyType::query()
            ->orderBy('Body_TID', 'asc')
            ->get([
                'Body_TID',
                'Body_Type',
            ]);

        return response()->json($uploadedCustomer);
    }



    public function getRegion(Request $request){
        $getRegion = Region::query()
                    ->orderBy('Customer_Type', 'asc')
                    ->get([
                        'RegCode',
                        'Region',
                        'PSGCode',
                    ]);

        return response()->json($getRegion);
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
