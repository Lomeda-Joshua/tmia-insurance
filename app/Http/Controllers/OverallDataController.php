<?php

namespace App\Http\Controllers;

use App\Models\Locations\Barangay;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\InsuranceStaff;
use App\Models\CustomerType;
use App\Models\UploadedCustomer;
use App\Models\Locations\Region;
use App\Models\Locations\Province;
use App\Models\Locations\CityMunicipal;

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
use App\Models\CustomerInformation;
use App\Models\VehicleInformation;
use Yajra\DataTables\Facades\DataTables;

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
            ->orderBy('Customer_No', 'asc')
            ->get([
                "Customer_No",
                "Group",
                "Full_Name",
                "First_Name",
                "Middle_Name",
                "Last_Name",
                "Suffix_Name",
                "Birth_Date",
                "TIN",
                "Contact_No",
                "Email_Address",
                "Address",
                "RegCode",
                "ProvCode",
                "CMCode",
                "BrgyCode",
                "Zip_Code",
                "Country",
                "VIN",
                "Variant",
                "Make",
                "Model",
                "Model_Year",
                "Color",
                "Engine_No",
                "CS_No",
                "Plate_No",
                "Order_No",
            ]);

            

        return DataTables::of($uploadedCustomer)
        ->addIndexColumn() // Adds DT_RowIndex
        ->make(true);      // Wraps response in { draw, recordsTotal, recordsFiltered, data }
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

    public function getProvince(Request $request) {
        $regcode = $request->input('regcode');

        $getProvince = Province::query()
            ->where('RegCode', $regcode)
            ->orderBy('ProvCode', 'asc')
            ->get(['ProvCode', 'Province', 'PSGCode']);

        return response()->json($getProvince);
    }

    public function getCityMunicipal(Request $request) {
        $provcode = $request->input('provcode');

        $getCityMunicipal = CityMunicipal::query()
            ->where('ProvCode', $provcode)
            ->orderBy('CMCode', 'asc')
            ->get(['CMCode', 'CityMunicipal', 'PSGCode']);

        return response()->json($getCityMunicipal);
    }

    public function getBarangay(Request $request) {
        $cmcode = $request->input('cmcode');

        $getBarangay = Barangay::query()
            ->where('CMCode', $cmcode)
            ->orderBy('BrgyCode', 'asc')
            ->get(['BrgyCode', 'Barangay', 'PSGCode']);

        return response()->json($getBarangay);
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

    public function getCustomerInfoData(Request $request)
    {
        // 1. Retrieve the 'custno' input from POST/GET request
        $custNo = $request->input('custno');

        // 2. Return empty response array if no customer number was passed
        if (empty($custNo)) {
            return response()->json([]);
        }

        // 3. Query the vw_customer_information database view using the CustomerInformation model
        $data = CustomerInformation::where('Customer_No', $custNo)->get();

        // 4. Return as JSON response (Laravel automatically handles header encoding)
        return response()->json($data);
    }



    public function getVehicleInfoData(Request $request)
    {
       // 1. Sanitize input strings
        $vin     = trim($request->input('vin', ''));
        $csno    = trim($request->input('csno', ''));
        $plateno = trim($request->input('plateno', ''));

        $data = collect();

        // Priority 1: Check by VIN
        if (!empty($vin)) {
            $data = VehicleInformation::where('VIN', $vin)->get();
        }

        // Priority 2: Check by CS_No if VIN has no results
        if ($data->isEmpty() && !empty($csno)) {
            $data = VehicleInformation::where('CS_No', $csno)->get();
        }

        // Priority 3: Check by Plate_No if VIN & CS_No have no results
        if ($data->isEmpty() && !empty($plateno)) {
            $data = VehicleInformation::where('Plate_No', $plateno)->get();
        }

        // 2. Return JSON response
        return response()->json($data);
    }



}
