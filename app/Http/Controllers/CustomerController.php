<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  

use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CustomerInformation; 
use App\Models\VehicleInformation; 
use App\Models\UploadedCustomer;
use App\Models\TransactionsNb;
use App\Models\FileNbUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

    public function index(){ 

        return view('livewire.main.transactions.customers');
    }

    
    /**
     * Fetch customer data for DataTables AJAX.
    */
    public function getCustomers(Request $request)
    {
        // 1. Return an Eloquent Query Builder (do NOT call ->get())
        $query = CustomerInformation::with('vehicles');

    
        // 2. Handle Alphabetical / Special Character Filter
        // Accepts 'btnselect' or 'letter' from JS payload
        $filter = $request->input('btnselect', $request->input('letter'));

        if (!empty($filter) && $filter !== 'ALL') {
                if ($filter === '[0-9]') {
                    $query->whereRaw("Full_Name REGEXP '^[0-9]'");
                } elseif ($filter === '[SPECIAL CHAR]') {
                    $query->whereRaw("Full_Name REGEXP '^[^a-zA-Z0-9]'");
                } else {
                    $query->where('Full_Name', 'like', "{$filter}%");
                }
            }


        // Determine and extract the search string safely
        $searchValue = null;
        
        if ($request->filled('searchval')) {
            $searchValue = $request->input('searchval');
        } elseif ($request->has('search') && is_array($request->input('search'))) {
            $searchValue = $request->input('search.value');
        } elseif ($request->filled('search') && is_string($request->input('search'))) {
            $searchValue = $request->input('search');
        }

        // Handle global search filter safely using a string value
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('Full_Name', 'like', "%{$searchValue}%")
                ->orWhere('Customer_No', 'like', "%{$searchValue}%")
                ->orWhere('Contact_No', 'like', "%{$searchValue}%")
                ->orWhere('Email_Address', 'like', "%{$searchValue}%");
            });
        }

       return DataTables::of($query)
        ->addIndexColumn() // Auto-generates dynamic "DT_RowIndex"
        ->setRowId('Customer_No')
        ->editColumn('Birth_Date', function ($row) {
            return !empty($row->Birth_Date) 
                ? \Carbon\Carbon::parse($row->Birth_Date)->format('d-M-Y') 
                : '';
        })
        ->editColumn('Active_Status', function ($row) {
            return ($row->Active_Status == '1' || strtoupper($row->Active_Status) === 'ACTIVE') 
                ? 'ACTIVE' 
                : 'INACTIVE';
        })
        ->addColumn('button', function ($row) {
            $custNoEscaped = e($row->Customer_No);
            
            $buttons  = '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnvehicle" data-toggle="tooltip" title="View Vehicle"><i class="fa fa-car"></i></label> ';
            $buttons .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" title="View & Modify"><i class="fa fa-edit"></i></label>';

            return $buttons;
        })
        ->rawColumns(['button'])
        ->make(true);
    }


    /**
     * Fetch customer data for DataTables AJAX.
    */
    public function show($custno)
    {
        $customer = CustomerInformation::where('Customer_No', $custno)->firstOrFail();
        return response()->json($customer);
    }


    /**
     * Store new customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_no' => 'required|unique:customers,customer_no',
            'group'       => 'required|string',
            'first_name'  => 'nullable|string',
            'last_name'   => 'nullable|string',
            'full_name'   => 'required|string',
            'email'       => 'required|email',
            'contact_no'  => 'required|string',
        ]);

        $customer = CustomerInformation::create($validated);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    
    /**
     * Show single customer for edit modal.
     */
    // public function show(CustomerInformation $customer)
    // {
    //     return response()->json($customer);
    // }


    /**
     * Update customer.
     */
    public function update(Request $request, CustomerInformation $customer)
    {
        $validated = $request->validate([
            'group'      => 'required|string',
            'full_name'  => 'required|string',
            'email'      => 'required|email',
            'contact_no' => 'required|string',
        ]);

        $customer->update($validated);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    /**
     * Delete customer.
     */
    public function destroy(CustomerInformation $customer)
    {
        $customer->delete();

        return response()->json(['success' => true]);
    }


    public function getCustomerDetails(Request $request)
    {
        $custNo = trim($request->input('custno'));

        if (empty($custNo)) {
            return response()->json([]);
        }

        // 1. Primary Lookup: Active Customer View
        $data = CustomerInformation::where('Upload_Cust_No', $custNo)->get();

        if ($data->isNotEmpty()) {
            $data->transform(function ($item) {
                $item->Cust_Exist = true;
                return $item;
            });

            return response()->json($data);
        }

        // 2. Fallback Lookup: Upload/Staging Table
        $data = UploadedCustomer::where('Customer_No', $custNo)->get();

        $data->transform(function ($item) {
            $item->Cust_Exist = false;
            return $item;
        });

        return response()->json($data);
    }


    public function checkCustomerData(Request $request): JsonResponse
    {
        $custNo = trim($request->input('custno', ''));

        if (empty($custNo)) {
            return response()->json([]);
        }

        // 1. Check in vw_customer_information first
        $customers = CustomerInformation::where('Upload_Cust_No', $custNo)->get();

        if ($customers->isNotEmpty()) {
            // Transform collection to set Cust_Exist = true
            $data = $customers->map(function ($item) {
                $array = $item->toArray();
                $array['Cust_Exist'] = true;
                return $array;
            });
        } else {
            // 2. Fallback: Not found, fetch from upload_customer_data
            $uploadedCustomers = UploadedCustomer::where('Customer_No', $custNo)->get();

            // Transform collection to set Cust_Exist = false
            $data = $uploadedCustomers->map(function ($item) {
                $array = $item->toArray();
                $array['Cust_Exist'] = false;
                return $array;
            });
        }

        return response()->json($data);
    }


    /**
     * Fetch customer data by Customer_No.
     */
    public function getCustomerByNo(Request $request): JsonResponse
    {
        $custNo = $request->input('custno');

        // Return empty array if no customer number was provided
        if (empty($custNo)) {
            return response()->json([]);
        }

        // Query view via Eloquent
        $data = CustomerInformation::where('Customer_No', $custNo)->get();

        return response()->json($data);
    }


    /**
     * Search vehicle information by priority: VIN -> CS_No -> Plate_No
     */
    public function searchVehicle(Request $request): JsonResponse
    {
        // 1. Sanitize and extract inputs
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


    public function getTransactionsByInsuranceNo(Request $request): JsonResponse
    {
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json([]);
        }

        // Eloquent query matching "SELECT * FROM transactions_nb WHERE Insurance_No = :insuranceno"
        $data = TransactionsNb::where('Insurance_No', $insuranceNo)->get();

        return response()->json($data);
    }


    /**
     * Fetch authenticated user state and attributes.
     */
    public function getAuthVariables(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'userid'     => $user?->User_ID ?? null,
            'logname'    => $user?->Display_Name ?? $user?->User_Name ?? null,
            'uname'      => $user?->User_Name ?? null,
            'ulevel'     => $user?->User_Level_ID ?? null,
            'regdate'    => $user?->Register_Date ?? null,
            'dealercode' => $user?->Dealer_ID ?? null,
            'signin'     => Auth::check(),
            'signout'    => ! Auth::check(),
        ]);
    }


    public function fileNbUpload(Request $request){
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json(null);
        }

        try {
            // Query uploaded file records ordered by date
            $files = FileNbUpload::where('Insurance_No', $insuranceNo)
                ->orderBy('Date_Time', 'asc')
                ->get();

            if ($files->isEmpty()) {
                return response()->json([]);
            }

            // Transform records to attach Base64 encoded file contents
            $data = $files->map(function ($row) use ($insuranceNo) {
                // Construct path using Laravel Storage disk or env variable
                $relativePath = 'INV/' . $insuranceNo . '/' . $row->Name;

                // Check local storage disk (or fallback to database BLOB column)
                if (Storage::disk('uploads')->exists($relativePath)) {
                    $fileContents = Storage::disk('uploads')->get($relativePath);
                    $encodedFile = $fileContents !== false ? base64_encode($fileContents) : null;
                } else {
                    // Fallback to database binary BLOB content
                    $encodedFile = !empty($row->File) ? base64_encode($row->File) : null;
                }

                $fileData = $row->toArray();
                $fileData['File'] = $encodedFile;

                return $fileData;
            });

            return response()->json($data);

        } catch (\Exception $e) {
            // Exceptions are caught and handled safely
            return response()->json(null, 500);
        }
    }


    

}
