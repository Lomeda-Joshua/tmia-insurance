<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\InsuranceStaff;
use App\Models\CustomerType;
use App\Models\UploadedCustomer;
use App\Models\Locations\Region;

use App\Models\Types\BodyType;
use App\Models\Types\CommunicationType;
use App\Models\Types\EwalletType;
use App\Models\Types\FuelType;
use App\Models\Types\InsuranceType;
use App\Models\InsuranceCo;
use App\Models\Types\PaymentType;
use App\Models\Bank;
use App\Models\ProductClass;
use App\Models\CallStatus;
use App\Models\TransactionStatus;


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

    public function getUploadedCustomer(Request $request){
        $uploadedCustomer = UploadedCustomer::query()
            ->orderBy('Customer_Type', 'asc')
            ->get([
                'Customer_TID',
                'Customer_Type',
            ]);

        return response()->json($uploadedCustomer);
    }


    public function getRegion(Request $request){
        $getRegion = Region::query()
                    ->orderBy('RegCode', 'asc')
                    ->get([
                        'RegCode',
                        'Region',
                        'PSGCode',
                    ]);

        return response()->json($getRegion);
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


    public function getBodyType(Request $request){
        $uploadedCustomer = BodyType::query()
            ->orderBy('Body_TID', 'asc')
            ->get([
                'Body_TID',
                'Body_Type',
            ]);

        return response()->json($uploadedCustomer);
    }

    public function getPaymentType(Request $request): JsonResponse
    {
        $paymentType = PaymentType::query()
            ->orderBy('PayTID', 'asc')
            ->get([
                'PayTID',
                'PayType',
            ]);

        return response()->json($paymentType);
    }


    public function getCommunicationType(Request $request): JsonResponse
    {
        $communicationType = CommunicationType::query()
            ->orderBy('Communication_ID', 'asc')
            ->get([
                'Communication_ID',
                'Communication_Type',
            ]);

        return response()->json($communicationType);
    }


    public function getEwalletType(Request $request): JsonResponse
    {
        $ewalletType = EwalletType::query()
            ->orderBy('EWTID', 'asc')
            ->get([
                'EWTID',
                'EWType',
            ]);

        return response()->json($ewalletType);
    }

    public function getFuelType(Request $request): JsonResponse
    {
        $fuelType = FuelType::query()
            ->orderBy('Fuel_TID', 'asc')
            ->get([
                'Fuel_TID',
                'Fuel_Type',
            ]);

        return response()->json($fuelType);
    }


    public function getInsuranceType(Request $request): JsonResponse
    {
        $insuranceType = InsuranceType::query()
            ->orderBy('Insurance_TID', 'asc')
            ->get([
                'Insurance_TID',
                'Insurance_Type',
            ]);

        return response()->json($insuranceType);
    }


        public function getInsuranceCo(Request $request): JsonResponse
    {
        $insuranceCo = InsuranceCo::query()
            ->orderBy('Insurance_ID', 'asc')
            ->get([
                'Insurance_ID',
                'Insurance_Desc',
            ]);

        return response()->json($insuranceCo);
    }



    public function getBank(Request $request): JsonResponse
    {
        $getBank = Bank::query()
            ->orderBy('BankID', 'asc')
            ->get([
                'BankID',
                'BankDesc',
                'BankAbbv'
            ]);

        return response()->json($getBank);
    }


    public function getProductClass(Request $request): JsonResponse
    {
        $productClass = ProductClass::query()
            ->orderBy('Prod_Class_ID', 'asc')
            ->get([
                'Prod_Class_ID',
                'Prod_Class',
            ]);

        return response()->json($productClass);
    }



    public function getCallStatus(Request $request): JsonResponse
    {
        $callStatus = CallStatus::query()
            ->orderBy('Call_SID', 'asc')
            ->get([
                'Call_SID',
                'Call_Status',
            ]);

        return response()->json($callStatus);
    }


        public function getTrasactionStatus(Request $request): JsonResponse
    {
        $transactionStatus = TransactionStatus::query()
            ->orderBy('Trans_SID', 'asc')
            ->get([
                'Trans_Status',
                'Business_Type',
            ]);

        return response()->json($transactionStatus);
    }



}
