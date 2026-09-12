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
use Illuminate\Support\Carbon;

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
        // 1. Base Query Builder instance (do NOT call ->get() or ->all())
        $query = UploadedCustomer::query()
            ->whereNotNull('Full_Name');

        // 2. Extract inputs from AJAX request
        $searchVal = trim($request->input('searchval', ''));
        $btnSelect = trim($request->input('btnselect', ''));

        // 3. Dynamic Filter Logic
        if (!empty($searchVal)) {
            $like = '%' . $searchVal . '%';
            $query->where(function ($q) use ($like) {
                $q->where('Customer_No', 'LIKE', $like)
                  ->orWhere('Full_Name', 'LIKE', $like)
                  ->orWhere('CS_No', 'LIKE', $like)
                  ->orWhere('Plate_No', 'LIKE', $like);
            });
        } elseif (strlen($btnSelect) === 1 && ctype_alpha($btnSelect)) {
            $query->whereRaw("TRIM(Full_Name) LIKE ?", [$btnSelect . '%']);
        } elseif ($btnSelect === '[0-9]') {
            $query->whereRaw("TRIM(Full_Name) REGEXP '^[0-9]'");
        } elseif ($btnSelect === '[SPECIAL CHAR]') {
            $query->whereRaw("TRIM(Full_Name) REGEXP '^[^a-zA-Z0-9]'");
        }

        // 4. Default Order
        $query->orderBy('Full_Name', 'ASC');

        // 5. Pass query engine directly into DataTables payload generator
        return DataTables::eloquent($query)
            ->addIndexColumn() // Generates 'DT_RowIndex' to replace legacy 'urutan'
            ->setRowId('Customer_No')
            ->make(true);
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

    public function getCustomerTypePost(): JsonResponse
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


    public function getVehicle(Request $request){
        // 1. Filter vehicles by Customer_No relationship key
        $custNo = $request->input('custno');

        $query = CustomerInformation::findOrFail($custNo)->vehicles();


        // 2. Return Yajra DataTables JSON payload[cite: 1]
        return DataTables::of($query)
            ->addIndexColumn() // Generates 'DT_RowIndex' for column 0
            ->editColumn('VSI_Date', function ($row) {
                return !empty($row->VSI_Date) 
                    ? strtoupper(Carbon::parse($row->VSI_Date)->format('d-M-Y')) 
                    : '';
            })
            ->editColumn('SRP', function ($row) {
                return !is_null($row->SRP) 
                    ? number_format((float)$row->SRP, 2, '.', ',') 
                    : '0.00';
            })
            ->addColumn('button', function ($row) {
                $vinEscaped = e($row->VIN);
                
                $buttons  = '<label vin="' . $vinEscaped . '" class="btn btn-sm btn-info btn-action btnviewveh" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></label> ';
                $buttons .= '<label vin="' . $vinEscaped . '" class="btn btn-sm btn-primary btn-action btneditveh" data-toggle="tooltip" title="Edit Vehicle"><i class="fa fa-edit"></i></label>';

                return $buttons;
            })
            ->rawColumns(['VSI_Date', 'SRP', 'button'])
            ->make(true);
    } 

/**
     * Retrieve user-related session variables as JSON.
     */
    public function getSessionVariables(): JsonResponse
    {
        return response()->json([
            'userid'     => session('userid'),
            'logname'    => session('logname'),
            'uname'      => session('uname'),
            'ulevel'     => session('ulevel'),
            'regdate'    => session('regdate'),
            'dealercode' => session('dealercode'),
            'signin'     => session('signin', false),
            'signout'    => session('signout', false),
        ]);
    }



}
