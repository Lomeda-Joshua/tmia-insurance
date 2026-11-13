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

use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class OverallDataController extends Controller
{


    /**
     * Fetch insurance staff data for DataTables AJAX.
     */
    public function getInsuranceStaff(): JsonResponse
    {
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Create a unique cache key for this user
        $cacheKey = "customer_type_user_{$userId}";

        // Retrieve from cache if exists; otherwise run query and cache for 10,000 seconds
        // $iseStaff = Cache::remember($cacheKey, 10000, function () {
        //     return InsuranceStaff::query()
        //             ->orderBy('ISE_Name')
        //             ->get([
        //                 'ISE_No',
        //                 'ISE_Name',
        //             ]);
        // });

        $iseStaff =  InsuranceStaff::query()
                    ->orderBy('ISE_Name')
                    ->get([
                        'ISE_No',
                        'ISE_Name',
                    ]);

        return response()->json($iseStaff);
    }

    public function getUploadedCustomer(Request $request){
        // 1. Base Query Builder instance (do NOT call ->get() or ->all())
        $query = UploadedCustomer::query()
            ->whereNotNull('Full_Name');

        // 2. Extract inputs from AJAX request
        $searchVal = trim($request->input('searchval', ''));
        $btnSelect = trim($request->input('btnselect', ''));

        //   3. Dynamic Filter Logic
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
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Create a unique cache key for this user
        $cacheKey = "customer_type_user_{$userId}";

        // Retrieve from cache if exists; otherwise run query and cache for 10,000 seconds
        $customerTypes = Cache::remember($cacheKey, 10000, function () {
            return CustomerType::query()
                ->orderBy('Customer_Type', 'asc')
                ->get([
                    'Customer_TID',
                    'Customer_Type',
                ]);
        });

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
            ->where('insType', $request->insType)
            ->orderBy('Insurance_Desc', 'asc')
            ->get(['Insurance_ID', 'Insurance_Desc']);

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
            $data = VehicleInformation::with(["customer","bodyTypeValue","fuelType"])->where('VIN', $vin)->get();
        }

        // Priority 2: Check by CS_No if VIN has no results
        if ($data->isEmpty() && !empty($csno)) {
            $data = VehicleInformation::with(["customer","bodyTypeValue","fuelType"])->where('CS_No', $csno)->get();
        }

        // Priority 3: Check by Plate_No if VIN & CS_No have no results
        if ($data->isEmpty() && !empty($plateno)) {
            $data = VehicleInformation::with(["customer","bodyTypeValue","fuelType"])->where('Plate_No', $plateno)->get();
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
        $user = Auth::user();
        
        return response()->json([
            'userid'     => $user->User_ID,
            'logname'    => $user->Display_Name,
            'uname'      => $user->User_Name,
            'ulevel'     => $user->User_Level_ID,
            'regdate'    => $user->Register_Date,
            'dealercode' => $user->Dealer_ID,
            'signin'     => session('signin', false),
            'signout'    => session('signout', false),
        ]);
    }


    public function checkExpiry(Request $request): JsonResponse
    {
        $userId = $request->session()->get('userid');

        $expired = DB::table('user')
            ->where('User_ID', $userId)
            ->whereDate('ExpireDate', '<=', now()->toDateString())
            ->exists();

        return response()->json($expired ? 1 : 0);
        
    }


    public function monthOptions(Request $request)
    {
        // Same guard as the original: redirect if not signed in
        // dd($request->session());
        // if (!$request->session()->has('signin')) {
        //     return redirect('401-error');
        // }
        $currentMonth = now()->month; // 1-12
        $html = '<option value="" disabled>PLEASE SELECT</option>';

        for ($m = 1; $m <= 12; $m++) {
            $value     = str_pad($m, 2, '0', STR_PAD_LEFT);
            $monthName = strtoupper(Carbon::create(2000, $m, 1)->format('F'));
            $selected  = ($m === $currentMonth) ? ' selected' : '';

            $html .= "<option value=\"{$value}\"{$selected}>{$monthName}</option>";
        }

        return response($html);
    }


    public function yearOptions(Request $request)
    {
        // Same guard as the original: redirect if not signed in
        // if (!$request->session()->has('signin')) {
        //     return redirect('401-error');
        // }

        $startYear   = 2000;
        $currentYear = now()->year;

        $html = '<option value="" disabled>PLEASE SELECT</option>';

        for ($year = $currentYear; $year >= $startYear; $year--) {
            $selected = ($year === $currentYear) ? ' selected' : '';
            $html .= "<option value=\"{$year}\"{$selected}>{$year}</option>";
        }

        return response($html);
    }




    private const COLUMNS = [
        'Insurance_No', 'Trans_Date', 'Trans_Status', 'Customer_No',
        'Full_Name', 'Contact_No', 'VIN', 'CS_No', 'Plate_No', 'Model',
        'Variant', 'Insurance_Company', 'ISE_Name', 'User_Full_Name',
    ];


    public function nbrbReport(Request $request)
    {
        $validated = $request->validate([
            'bustype'    => 'nullable|string',
            'transtatus' => 'nullable|string',
            'datefrom'   => 'nullable|date_format:d-m-Y',
            'dateto'     => 'nullable|date_format:d-m-Y',
        ]);

        $busType    = strtoupper($validated['bustype'] ?? '');
        $tranStatus = $validated['transtatus'] ?? '';

        $dateFrom = $dateTo = null;
        if (!empty($validated['datefrom']) && !empty($validated['dateto'])) {
            $dateFrom = Carbon::createFromFormat('d-m-Y', $validated['datefrom'])->startOfDay();
            $dateTo   = Carbon::createFromFormat('d-m-Y', $validated['dateto'])->addDay()->startOfDay(); // exclusive
        }

        // One reusable filter builder instead of four copy-pasted blocks
        $build = fn (string $view) => DB::table($view)
            ->select(self::COLUMNS)
            ->when($tranStatus !== '' && strtoupper($tranStatus) !== 'ALL',
                fn ($q) => $q->where('Trans_Status', $tranStatus))
            ->when($dateFrom && $dateTo,
                fn ($q) => $q->where('Trans_Date', '>=', $dateFrom)
                             ->where('Trans_Date', '<', $dateTo));

        $query = match ($busType) {
            'RENEWAL BUSINESS' => $build('vw_transactions_rb'),
            'ALL'              => $build('vw_transactions_nb')->unionAll($build('vw_transactions_rb')),
            default            => $build('vw_transactions_nb'), // NEW BUSINESS and fallback
        };

        $data = $query->get()
            ->values()
            ->map(function ($row, $i) {
                $row = (array) $row;
                $row['urutan'] = $i + 1;
                return $row;
            });

        return response()->json($data);
    }






}
