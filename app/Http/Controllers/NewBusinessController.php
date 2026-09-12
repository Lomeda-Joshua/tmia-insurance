<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBusinessDatatableRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\NewBusinessTransactionView;
use App\Models\NewBusiness;
use App\Models\CustomerInformation;
use App\Models\VehicleInformation;
use App\Models\TransactionsNb;
use App\Models\TransactionNbPayment;
use App\Models\Notification;
use App\Models\FileNbUpload;
use App\Models\UploadedEdafCustomer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class NewBusinessController extends Controller
{
    public function index(){        
        return view('livewire.main.transactions.new_business');
    }

    /**
     * Fetch New business data for DataTables AJAX.
    */
    public function getNewBusiness(NewBusinessDatatableRequest $request): JsonResponse
    {
        // 1. Build Base Query with Joins using Eloquent or Query Builder
        $query = NewBusinessTransactionView::query()
            ->from('transactions_nb as t')
            ->select([
                't.Insurance_No',
                't.Trans_Date',
                't.Trans_Status',
                't.Customer_No',
                'c.Full_Name',
                'c.Contact_No',
                't.VIN',
                'v.CS_No',
                'v.Plate_No',
                'v.Model',
                'v.Variant',
                't.Insurance_Company',
                'i.ISE_Name',
                'v.MP_Name',
                't.Option_Type',
            ])
            ->leftJoin('customer_information as c', 't.Customer_No', '=', 'c.Customer_No')
            ->leftJoin('vehicle_information as v', 't.VIN', '=', 'v.VIN')
            ->leftJoin('vw_insurance_staff as i', 't.ISE_No', '=', 'i.ISE_No');
            // ->groupBy('t.Customer_No');

            // 2. Extract Request Inputs
            $viewPending  = $request->boolean('viewpending');
            $viewExpiring = $request->boolean('viewexpiring');
            $searchVal    = trim($request->input('searchval', ''));
            $dateFrom     = $request->input('datefrom');
            $dateTo       = $request->input('dateto');
            $chkAll       = $request->integer('chkall', 0);

            // 3. Dynamic Filtering Logic
            if ($viewPending) {
                $query->where('t.Trans_Status', 'PENDING');
            } elseif ($viewExpiring) {
                $query->whereBetween('t.Policy_Expiration', [
                    now()->startOfDay(),
                    now()->addDays(90)->endOfDay(),
                ]);
            } elseif (!empty($searchVal)) {
                $search = '%' . $searchVal . '%';
                $query->where(function ($q) use ($search) {
                    $q->where('t.Insurance_No', 'LIKE', $search)
                    ->orWhere('t.VIN', 'LIKE', $search)
                    ->orWhere('v.Order_No', 'LIKE', $search)
                    ->orWhere('v.CS_No', 'LIKE', $search)
                    ->orWhere('v.Plate_No', 'LIKE', $search)
                    ->orWhere('v.Customer_No', 'LIKE', $search)
                    ->orWhere('c.Full_Name', 'LIKE', $search);
                });
            } elseif ($chkAll === 0 && !empty($dateFrom) && !empty($dateTo)) {
                $query->whereBetween('t.Trans_Date', [
                    Carbon::parse($dateFrom)->startOfDay(),
                    Carbon::parse($dateTo)->endOfDay(),
                ]);
            }

            // 4. Return Yajra DataTables Server-Side Processing Payload
            return DataTables::of($query)
                ->addIndexColumn() // Generates 'DT_RowIndex' (urutan)
                ->editColumn('Trans_Status', function ($row) {
                    $insuranceNo = e($row->Insurance_No);
                    $statusRaw   = $row->Trans_Status ?? '';
                    $status      = strtoupper(trim(preg_replace('/\s+/u', ' ', $statusRaw)));

                    $statusColors = [
                        'PENDING'   => 'label label-default',
                        'COMPLETED' => 'label label-success',
                        'CANCELLED' => 'label label-danger',
                    ];

                    $labelClass = $statusColors[$status] ?? 'label label-default';

                    return '<span insuranceno="' . $insuranceNo . '" class="badge ' . $labelClass . '">' . e($statusRaw) . '</span>';
                })
                ->addColumn('button', function ($row) {
                    $insuranceNo = e($row->Insurance_No);
                    $buttons = '';

                    if ($row->Option_Type === 'PAID') {
                        $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnpay" data-toggle="tooltip" title="Payment"><i class="fa-solid fa-peso-sign"></i></label> ';
                    }

                    $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnnetrem" data-toggle="tooltip" title="Gross Premium / Net Rem"><i class="fa-solid fa-money-bill-transfer"></i></label> ';
                    $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnstatus" data-toggle="tooltip" title="Change Status"><i class="fa-solid fa-chart-bar"></i></label> ';
                    $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" title="View & Modify"><i class="fa fa-edit"></i></label> ';
                    $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btndelete" data-toggle="tooltip" title="Delete"><i class="fa-regular fa-trash-can"></i></label>';

                    return $buttons;
                })
                ->rawColumns(['Trans_Status', 'button'])
                ->make(true);
    }

    /**
     * For commencing the data retriveal on New Business pending counts.
    */
    public function nbPendingCounts(): JsonResponse
    {
        $counts = NewBusiness::query()
            ->selectRaw("
                COUNT(CASE WHEN Trans_Status = 'PENDING' THEN 1 END) AS Pending_Counts,
                COUNT(
                    CASE
                        WHEN Policy_Expiration BETWEEN CURDATE()
                        AND DATE_ADD(CURDATE(), INTERVAL 90 DAY)
                        THEN 1
                    END
                ) AS Expiring_Counts
            ")
            ->first();

        return response()->json([
            'Pending_Counts' => (int) $counts->Pending_Counts,
            'Expiring_Counts' => (int) $counts->Expiring_Counts,
        ]);
    }

    /**
     * For saving data of New business.
    */
    public function store(Request $request)
    {       
        $user = Auth::user();
        $userid = $user->User_ID;
        $ulevel = $user->User_Level_Description ?? '';

        try {
            DB::beginTransaction();
            /* ============================================================
               1) CUSTOMER INSERT OR UPDATE
               ============================================================ */
            $custno = $request->input('custno');
            $existingCust = CustomerInformation::where('Customer_No', $custno)->first();

            $customerData = [
                'User_ID'        => $userid,
                'Group'          => $request->input('group', ''),
                'Full_Name'      => $request->input('custname', ''),
                'First_Name'     => $request->input('custfname', ''),
                'Middle_Name'    => $request->input('custmname', ''),
                'Last_Name'      => $request->input('custlname', ''),
                'Suffix_Name'    => $request->input('custsname', ''),
                'Birth_Date'     => $request->input('birthdate') ?: null,
                'TIN'            => $request->input('tin', ''),
                'Contact_No'     => $request->input('contactno', ''),
                'Email_Address'  => $request->input('emailadd', ''),
                'Address'        => $request->input('address', ''),
                'RegCode'        => $request->input('region', ''),
                'ProvCode'       => $request->input('province', ''),
                'CMCode'         => $request->input('city', ''),
                'BrgyCode'       => $request->input('brgy', ''),
                'Zip_Code'       => $request->input('zipcode', ''),
                'Country'        => $request->input('country', ''),
                'Upload_Cust_No' => $request->input('custnoupload', ''),
            ];

            if ($existingCust) {
                $existingCust->update($customerData);
                $finalCustNo = $custno;
            } else {
                $yearc = date("Y");
                $prefixc = "TMIA-{$yearc}-";

                $lastc = CustomerInformation::where('Customer_No', 'LIKE', $prefixc . '%')
                    ->orderBy('Customer_No', 'desc')
                    ->lockForUpdate()
                    ->first();

                $seqc = "0000001";
                if ($lastc && preg_match('/^TMIA-(\d{4})-(\d{7})$/', $lastc->Customer_No, $mc)) {
                    if ($mc[1] == $yearc) {
                        $seqc = str_pad(intval($mc[2]) + 1, 7, "0", STR_PAD_LEFT);
                    }
                }

                $finalCustNo = "TMIA-{$yearc}-{$seqc}";
                $customerData['Customer_No'] = $finalCustNo;
                $customerData['Active_Status'] = 1;

                CustomerInformation::create($customerData);
            }

            /* ============================================================
               2) VEHICLE INSERT OR UPDATE
               ============================================================ */
            $vin = $request->input('vin');
            $existingVehicle = VehicleInformation::where('VIN', $vin)->first();

            $vehicleData = [
                'Make'           => $request->input('make', ''),
                'Model'          => $request->input('model', ''),
                'Model_Year'     => $request->input('modelyear', ''),
                'Color'          => $request->input('color', ''),
                'Engine_No'      => $request->input('engineno', ''),
                'CS_No'          => $request->input('csno', ''),
                'Plate_No'       => $request->input('plateno', ''),
                'SRP'            => floatval($request->input('paidprice', 0)),
                'VSI_Date'       => $request->input('vsidate') ?: null,
                'Released_Date'  => $request->input('reldate') ?: null,
                'Technical_Date' => $request->input('techdate') ?: null,
                'Variant'        => $request->input('variant', ''),
                'Body_Type'      => $request->input('bodytype', ''),
                'Transmission'   => $request->input('transmission', ''),
                'Fuel_Type'      => $request->input('fueltype', ''),
                'Seats'          => $request->input('seats', ''),
                'Prod_Classify'  => $request->input('prodclass', ''),
                'Owner_Type'     => $request->input('owntype', ''),
                'Owner_Name'     => $request->input('voname', ''),
                'MP_Name'        => $request->input('mpname', ''),
                'Customer_No'    => $finalCustNo
            ];

            if ($existingVehicle) {
                $existingVehicle->update($vehicleData);
            } else {
                $vehicleData['VIN'] = $vin;
                VehicleInformation::create($vehicleData);
            }

            /* ============================================================
               3) GENERATE INSURANCE NUMBER
               ============================================================ */
            $year = date("Y");
            $prefix = "NB-{$year}-";

            $last = TransactionsNb::where('Insurance_No', 'LIKE', $prefix . '%')
                ->orderBy('Insurance_No', 'desc')
                ->lockForUpdate()
                ->first();

            $seq = "0000001";
            if ($last && preg_match('/^NB-(\d{4})-(\d{7})$/', $last->Insurance_No, $m)) {
                if ($m[1] == $year) {
                    $seq = str_pad(intval($m[2]) + 1, 7, "0", STR_PAD_LEFT);
                }
            }

            $insuranceno = "NB-{$year}-{$seq}";

            if ($ulevel === 'INSURANCE STAFF') {
                $iseno = $userid;
            } else {
                $iseno = $request->input('iseno') ?: null;
            }

            /* ============================================================
               4) INSERT NEW INSURANCE RECORD
               ============================================================ */
            TransactionsNb::create([
                'Insurance_No'      => $insuranceno,
                'Gross_Premium'     => floatval($request->input('grosspremium', 0)),
                'Net_Rem'           => floatval($request->input('netremittance', 0)),
                'Commission'        => floatval($request->input('commission', 0)),
                'Option_Type'       => $request->input('optiontype', 'FREE'),
                'Install_Pay'       => intval($request->input('chkpayment', 0)),
                'Month_Terms'       => $request->input('terms', ''),
                'Month_Pay'         => floatval($request->input('monthpay', 0)),
                'Insurance_Type'    => $request->input('instype', ''),
                'Insurance_Company' => $request->input('insco', ''),
                'Start_Date'        => $request->input('startdate') ?: null,
                'Policy_No'         => $request->input('policyno', ''),
                'Issue_Date'        => $request->input('issuedate') ?: null,
                'Policy_Expiration' => $request->input('pexpiredate') ?: null,
                'Mortgage'          => $request->input('mortgage', ''),
                'Customer_No'       => $finalCustNo,
                'VIN'               => $vin,
                'Trans_Date'        => now(),
                'ISE_No'            => $iseno,
                'User_ID'           => $userid,
            ]);

            /* ============================================================
               5) PAYMENTS INSERTION
               ============================================================ */
            $rawPayments = $request->input('payments');
            $payments = is_string($rawPayments) ? json_decode($rawPayments, true) : $rawPayments;

            if (is_array($payments)) {
                foreach ($payments as $p) {
                    $pdcDate = (!empty($p['PDC_Date']) && strtotime($p['PDC_Date']) !== false) 
                        ? date('Y-m-d', strtotime($p['PDC_Date'])) 
                        : null;

                    TransactionNbPayment::create([
                        'Insurance_No'      => $insuranceno,
                        'User_ID'           => $userid,
                        'Payment_Type'      => $p['Payment_Type'] ?? null,
                        'EWallet_Type'      => $p['EWallet_Type'] ?? null,
                        'PDC_No'            => $p['PDC_No'] ?? null,
                        'PDC_Account_Name'  => $p['PDC_Account_Name'] ?? null,
                        'PDC_Bank_Name'     => $p['PDC_Bank_Name'] ?? null,
                        'PDC_Date'          => $pdcDate,
                        'Payment_Terms'     => $p['Payment_Terms'] ?? null,
                        'Payment_Amount'    => isset($p['Payment_Amount']) ? floatval($p['Payment_Amount']) : null,
                        'Payment_Date'      => now(),
                    ]);
                }
            }

            /* ============================================================
               6) NOTIFICATION
               ============================================================ */
            Notification::create([
                'Insurance_No'     => $insuranceno,
                'Business_Type'    => 'NEW BUSINESS',
                'Insurance_Status' => 'PENDING',
                'Title'            => '[New Business Insurance - ' . $insuranceno . ']',
                'Message'          => $request->input('custname', '') . ' created a new request',
                'Info_Type'        => 'info',
                'URL'              => 'new_business_modify',
                'Status'           => 'unread',
                'Created_Date'     => now(),
                'User_ID'          => $userid,
            ]);

            DB::commit();

            return response()->json([
                'result'       => 1, 
                'Insurance_No' => $insuranceno
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'result' => 0, 
                'error'  => $e->getMessage()
            ], 500);
        }
    }


    public function getTransactionsNB(Request $request){
        $insuranceNo = $request->input('insuranceno');  
        if (!empty($insuranceNo)) {
            // Using Eloquent ORM
            $data = TransactionsNb::where('Insurance_No', $insuranceNo)->get();
            // Alternatively, using Query Builder:
            // $data = \DB::table('transactions_nb')->where('Insurance_No', $insuranceNo)->get();
        }
        

        return response()->json($data);
    }

    public function getNewBusinessPayment(Request $request)
    {
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json(['data' => []]);
        }

        // Fetch matching records via Eloquent
        $payments = TransactionNBpayment::where('Insurance_No', $insuranceNo)->get();

        // Transform the collection to attach row index ('urutan') and action buttons
        $data = $payments->values()->map(function ($row, $index) {
            $payId = e($row->Payment_ID);

            return array_merge($row->toArray(), [
                'urutan' => $index + 1,
                'button' => '<label payid="' . $payId . '" class="btn btn-success btn-action btnremovepaysave" data-toggle="tooltip" data-placement="top" title="Remove">'
                          . '<i class="fa-regular fa-trash-can"></i>'
                          . '</label>',
            ]);
        });

        return response()->json(['data' => $data]);
    }


    /**
     * Store insurance, customer, and VIN parameters in the session.
     */
    public function setTransactionSession(Request $request): JsonResponse
    {
        // Store inputs into Laravel's session (defaults to empty string if missing)
        session([
            'insuranceno' => $request->input('insuranceno', ''),
            'cusno'       => $request->input('cusno', ''),
            'vin'         => $request->input('vin', ''),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Session updated successfully',
        ]);
    }


    public function getModifyView(){
        return view('livewire.main.transactions.new_business_modify');
    }

    /**
     * Fetch uploaded files by Insurance Number and encode contents to Base64.
     */
    public function getUploadedFiles(Request $request): JsonResponse
    {
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

    /**0
     * Fetch vehicle information by Customer_No and wrap in a DataTables-friendly array structure.
     */
    public function getVehiclesByCustomer(Request $request): JsonResponse
    {
        $custNo = trim($request->input('custno', ''));

        // 1. Return empty engine payload if no customer number provided
        if (empty($custNo)) {
            return DataTables::of(collect([]))->make(true);
        }

        // 2. Pass base Query Builder directly (DO NOT execute ->get() first)
        $query = VehicleInformation::where('Customer_No', $custNo);

        // 3. Process Yajra DataTables payload response
        return DataTables::of($query)
            ->addIndexColumn() // Generates dynamic 'DT_RowIndex'
            ->editColumn('VSI_Date', function ($row) {
                return !empty($row->VSI_Date) 
                    ? \Carbon\Carbon::parse($row->VSI_Date)->format('d-M-Y') 
                    : '';
            })
            ->editColumn('SRP', function ($row) {
                return $row->SRP ?? 0;
            })
            ->make(true);
    }

    /**
     * Fetch uploaded customer data for server-side DataTables.
     */
    public function getUploadedCustomersEdaf(Request $request): JsonResponse
    {
        $custNo = trim($request->input('custno', ''));

        // 1. If no Customer_No provided, return an empty DataTables structure
        // if (empty($custNo)) {
        //     return DataTables::of(collect([]))->make(true);
        // }

        // 2. Base Query Builder (do NOT call ->get() or ->fetchAll())
        $query = UploadedEdafCustomer::where('Customer_No', $custNo)->with('customer');
            // ->orderBy('Model_Year', 'ASC');

        // dd($query);

        // 3. Process Yajra DataTables engine
        return DataTables::of($query)
            ->addIndexColumn() // Generates dynamic 'DT_RowIndex' (replaces legacy 'urutan')
            ->setRowId('Customer_No')
            ->addColumn('button', function ($row) {
                // Return placeholder or row action buttons if needed
                return '';
            })
            ->rawColumns(['button'])
            ->make(true);
    }


    /**
     * Delete a transaction by Insurance Number.
     */
    public function removeByInsuranceNo(Request $request): JsonResponse
    {
        $insuranceNo = trim($request->input('insuranceno', ''));

        if (empty($insuranceNo)) {
            return response()->json([
                'result' => 0, 
                'error'  => 'Insurance number is required'
            ]);
        }

        try {
            // Delete using Eloquent ORM (returns count of deleted rows)
            $deletedCount = TransactionsNb::where('Insurance_No', $insuranceNo)->delete();

            if ($deletedCount > 0) {
                return response()->json(['result' => 1]);
            }

            return response()->json([
                'result' => 0, 
                'error'  => 'No matching record found'
            ]);

        } catch (\Exception $e) {
            // Log error internally using Laravel Logger
            Log::error('Database error during transaction deletion: ' . $e->getMessage());

            return response()->json([
                'result' => 0, 
                'error'  => 'Database error occurred'
            ]);
        }
    }

    


}
