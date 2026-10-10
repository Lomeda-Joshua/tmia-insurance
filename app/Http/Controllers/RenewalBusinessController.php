<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenewalBusinessDatatableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

use App\Models\RenewalBusinessTransaction;
use App\Models\CustomerInformation;
use App\Models\VehicleInformation;
use App\Models\TransactionRBPayment;
use App\Models\Notification;
use App\Models\TransactionRb;
use App\Models\TransactionsNb;
use App\Models\ApprovalRbStatus;

use Illuminate\Support\Facades\Auth;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;

class RenewalBusinessController extends Controller 
{
    public function index(){
        return view('livewire.main.transactions.renewal_business');
    }

    public function getRenewalTableData(RenewalBusinessDatatableRequest $request): JsonResponse
    {
        $filters = $request->validated();     

        // 1. Build Base Query with Joins
        $query = RenewalBusinessTransaction::query()
            ->leftJoin('customer_information', 'transactions_rb.Customer_No', '=', 'customer_information.Customer_No')
            ->leftJoin('vehicle_information', 'transactions_rb.VIN', '=', 'vehicle_information.VIN') // Adjust join key if using CS_No\
            ->leftJoin('user', 'transactions_rb.User_ID', '=', 'user.User_ID') 
            ->leftJoin('user as ise_name', 'transactions_rb.ISE_No', '=', 'ise_name.User_ID')
            ->leftJoin('vw_call_attempts_rb', 'vw_call_attempts_rb.Insurance_No', '=', 'transactions_rb.Insurance_No')
            ->select([
                // Primary table columns (prefixed to avoid ambiguous column collisions)
                'transactions_rb.Insurance_No',
                'transactions_rb.Trans_Date',
                'transactions_rb.Trans_Status',
                'transactions_rb.VIN',
                'transactions_rb.Customer_No',
                'transactions_rb.Insurance_Company',
                'transactions_rb.Option_Type',
                'transactions_rb.Policy_Expiration',
                'transactions_rb.ISE_No',

                'ise_name.Display_Name as ise_name',

                // Columns from Related Tables (Flattened directly for DataTables)
                'customer_information.Full_Name',
                'customer_information.Contact_No',

                'vehicle_information.CS_No',
                'vehicle_information.Plate_No',
                'vehicle_information.Make',
                'vehicle_information.Model',
                'vehicle_information.Model_Year',
                'vehicle_information.Variant',

                'vw_call_attempts_rb.Call_Attempts'
        ]);

        
        // 2. Pending Filter
        if (! empty($filters['viewpending'])) {
            $query->where('transactions_rb.Trans_Status', 'PENDING');
        }

        // 3. Expiring Filter
        if (! empty($filters['viewexpiring'])) {
            $query->whereBetween('transactions_rb.Policy_Expiration', [
                now()->startOfDay(),
                now()->addDays(90)->endOfDay(),
            ]);
        }

        // 4. Custom Search Filter (Runs regardless of Date Range)
        if (! empty($filters['searchval'])) {
            $search = '%' . trim($filters['searchval']) . '%';

            $query->where(function ($q) use ($search) {
                $q->where('transactions_rb.Insurance_No', 'like', $search)
                ->orWhere('transactions_rb.VIN', 'like', $search)
                ->orWhere('transactions_rb.Customer_No', 'like', $search)
                ->orWhere('customer_information.Full_Name', 'like', $search)
                ->orWhere('customer_information.Contact_No', 'like', $search)
                ->orWhere('vehicle_information.CS_No', 'like', $search)
                ->orWhere('vehicle_information.Plate_No', 'like', $search);
            });
        }

        // 5. Date Range Filter (Only applies when chkall is false AND searchval is empty)
            if (
                empty($filters['chkall']) &&
                empty($filters['searchval']) &&
                ! empty($filters['datefrom']) &&
                ! empty($filters['dateto'])
            ) {
                $query->whereBetween('transactions_rb.Trans_Date', [
                    Carbon::createFromFormat('d-m-Y', $filters['datefrom'])->startOfDay(),
                    Carbon::createFromFormat('d-m-Y', $filters['dateto'])->endOfDay(),
                ]);
            }


        return DataTables::eloquent($query)
            ->addIndexColumn() // Provides DT_RowIndex / urutan
            ->editColumn('Trans_Status', function($transaction): string{
                    $insuranceNo = e($transaction->Insurance_No);
                    $statusRaw   = $transaction->Trans_Status ?? '';
                    $status      = strtoupper(trim(preg_replace('/\s+/u', ' ', $statusRaw)));

                    $statusColors = [
                        'PENDING'   => '#5bc0de',
                        'COMPLETED' => '#22bb33',
                        'CANCELLED' => '#bb2124',
                    ];

                $labelClass = $statusColors[$status] ?? '#777777';
                return '<span insuranceno="' . $insuranceNo . '" class="badge" style="background-color:' . $labelClass . ';">' . e($statusRaw) . '</span>';
            })
            ->addColumn('button', function ($transaction): string {
                $insuranceNo = e($transaction->Insurance_No);
                $buttons = '';

                // Added Print PDF Button
                $buttons .= '<a href="' . route('renewal.pdf.generate', ['insurance_no' => $insuranceNo]) . '" target="_blank" '
                    . 'class="btn btn-sm btn-primary btn-action btnprintpdf me-1" title="Print PDF">'
                    . '<i class="fa-solid fa-file-pdf"></i></a>';

                if ($transaction->Option_Type === 'PAID') {
                    $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btnpay me-1" '
                        . 'data-insurance-no="' . $insuranceNo . '" title="Payment">'
                        . '<i class="fa-solid fa-peso-sign"></i></button>';
                }

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btnnetrem me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Gross Premium / Net Rem">'
                    . '<i class="fa-solid fa-money-bill-transfer"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btnstatus me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Change Status">'
                    . '<i class="fa-solid fa-chart-bar"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btncall me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="View & Call">'
                    . '<i class="fa-solid fa-phone"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btncalllog me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="View Call Logs">'
                    . '<i class="fa-solid fa-volume-control-phone"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btnedit me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="View and Modify">'
                    . '<i class="fa fa-edit"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-danger btn-action btndelete" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Delete">'
                    . '<i class="fa-regular fa-trash-can"></i></button>';

                return $buttons;
            })
            ->rawColumns(['button', 'Trans_Status'])
            ->make(true);
    }

    /**
     * Helper to validate Y-m-d date string formats.
     */
    private function isValidDate(?string $date): bool
    {
        if (!$date) {
            return false;
        }

        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

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
     * Retrieve transaction metric counts for pending status and expiring policies.
     */
    public function getTransactionMetrics(): JsonResponse
    {
        $metrics = DB::table('transactions_rb')
            ->selectRaw("
                COUNT(CASE WHEN Trans_Status = 'PENDING' THEN 1 END) AS Pending_Counts,
                COUNT(CASE WHEN Policy_Expiration BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 90 DAY) THEN 1 END) AS Expiring_Counts
            ")
            ->first();

        return response()->json($metrics);
    }



    /**
     * Store new renewal business transaction, customer, vehicle, payments, and notification.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveRenewalBusiness(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'custno'       => 'nullable|string',
            'custnoupload' => 'nullable|string',
            'group'        => 'nullable|string',
            'custname'     => 'required|string',
            'custfname'    => 'nullable|string',
            'custmname'    => 'nullable|string',
            'custlname'    => 'nullable|string',
            'custsname'    => 'nullable|string',
            'birthdate'    => 'nullable|date',
            'tin'          => 'nullable|string',
            'contactno'    => 'nullable|string',
            'emailadd'     => 'nullable|email',
            'address'      => 'nullable|string',
            'region'       => 'nullable|string',
            'province'     => 'nullable|string',
            'city'         => 'nullable|string',
            'brgy'         => 'nullable|string',
            'zipcode'      => 'nullable|string',
            'country'      => 'nullable|string',

            'vin'          => 'required|string',
            'make'         => 'nullable|string',
            'model'        => 'nullable|string',
            'modelyear'    => 'nullable|string',
            'color'        => 'nullable|string',
            'engineno'     => 'nullable|string',
            'csno'         => 'nullable|string',
            'plateno'      => 'nullable|string',
            'paidprice'    => 'nullable|numeric',
            'vsidate'      => 'nullable|date',
            'reldate'      => 'nullable|date',
            'techdate'     => 'nullable|date',
            'variant'      => 'nullable|string',
            'bodytype'     => 'nullable|string',
            'transmission' => 'nullable|string',
            'fueltype'     => 'nullable|string',
            'seats'        => 'nullable|string',
            'prodclass'    => 'nullable|string',
            'owntype'      => 'nullable|string',
            'voname'       => 'nullable|string',
            'mpname'       => 'nullable|string',

            'grosspremium'  => 'nullable|numeric',
            'netremittance' => 'nullable|numeric',
            'commission'    => 'nullable|numeric',
            'optiontype'    => 'nullable|string',
            'chkpayment'    => 'nullable|integer',
            'terms'         => 'nullable|string',
            'monthpay'      => 'nullable|numeric',
            'instype'       => 'nullable|string',
            'insco'         => 'nullable|string',
            'startdate'     => 'nullable|date',
            'policyno'      => 'nullable|string',
            'issuedate'     => 'nullable|date',
            'pexpiredate'   => 'nullable|date',
            'mortgage'      => 'nullable|string',
            'iseno'         => 'nullable|string',
            'payments'      => 'required|json',
        ]);

        // Decode payments JSON string
        $payments = json_decode($request->input('payments'), true);
        if (!is_array($payments)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid JSON data for payments'
            ], 400);
        }

        $user = Auth::user();
        $userId = $user->id ?? Auth::id();
        $userLevel = $user->ulevel ?? session('ulevel');

        try {
            return DB::transaction(function () use ($request, $payments, $userId, $userLevel) {

                // ----------------------------
                // A) CUSTOMER INSERT OR UPDATE
                // ----------------------------
                $custNo = $request->input('custno');                
                $customer = CustomerInformation::find($custNo);
                
                $customerData = [ 
                    'Group'          => $request->input('group', ''),
                    'Full_Name'      => $request->input('custname', ''),
                    'First_Name'     => $request->input('custfname', ''),
                    'Middle_Name'    => $request->input('custmname', ''),
                    'Last_Name'      => $request->input('custlname', ''),
                    'Suffix_Name'    => $request->input('custsname', ''),
                    'Birth_Date'     => $request->input('birthdate'),
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

                if ($customer) {
                    $customer->update($customerData);
                } else {
                    // Generate Unique Customer No
                    $yearc = date('Y');
                    $prefixc = "TMIA-{$yearc}-";

                    $lastCustomer = CustomerInformation::where('Customer_No', 'LIKE', "{$prefixc}%")
                        ->lockForUpdate()
                        ->orderBy('Customer_No', 'desc')
                        ->first();

                    $seqc = "0000001";
                    if ($lastCustomer && preg_match('/^TMIA-(\d{4})-(\d{7})$/', $lastCustomer->Customer_No, $mc)) {
                        if ($mc[1] == $yearc) {
                            $seqc = str_pad(((int) $mc[2]) + 1, 7, '0', STR_PAD_LEFT);
                        }
                    }

                    $custNo = "TMIA-{$yearc}-{$seqc}";
                    $customerData['Customer_No'] = $custNo;
                    $customerData['Active_Status'] = 1;

                    CustomerInformation::create($customerData);
                }

                // ----------------------------
                // B) VEHICLE INSERT OR UPDATE
                // ----------------------------
                $vin = $request->input('vin');
                $vehicle = VehicleInformation::find($vin);

                $vehicleData = [
                    'Make'           => $request->input('make', ''),
                    'Model'          => $request->input('model', ''),
                    'Model_Year'     => $request->input('modelyear', ''),
                    'Color'          => $request->input('color', ''),
                    'Engine_No'      => $request->input('engineno', ''),
                    'CS_No'          => $request->input('csno', ''),
                    'Plate_No'       => $request->input('plateno', ''),
                    'SRP'            => (float) $request->input('paidprice', 0),
                    'VSI_Date'       => $request->input('vsidate'),
                    'Released_Date'  => $request->input('reldate'),
                    'Technical_Date' => $request->input('techdate'),
                    'Variant'        => $request->input('variant', ''),
                    'Body_Type'      => $request->input('bodytype', ''),
                    'Transmission'   => $request->input('transmission', ''),
                    'Fuel_Type'      => $request->input('fueltype', ''),
                    'Seats'          => $request->input('seats', ''),
                    'Prod_Classify'  => $request->input('prodclass', ''),
                    'Owner_Type'     => $request->input('owntype', ''),
                    'Owner_Name'     => $request->input('voname', ''),
                    'MP_Name'        => $request->input('mpname', ''),
                    'Customer_No'    => $custNo,
                ];

                if ($vehicle) {
                    $vehicle->update($vehicleData);
                } else {
                    $vehicleData['VIN'] = $vin;
                    VehicleInformation::create($vehicleData);
                }

                // ----------------------------
                // C) GENERATE INSURANCE NO
                // ----------------------------
                $year = date('Y');
                $prefix = "RB-{$year}-";

                $lastTransaction = RenewalBusinessTransaction::where('Insurance_No', 'LIKE', "{$prefix}%")
                    ->lockForUpdate()
                    ->orderBy('Insurance_No', 'desc')
                    ->first();

                $seq = "0000001";
                if ($lastTransaction && preg_match('/^RB-(\d{4})-(\d{7})$/', $lastTransaction->Insurance_No, $m)) {
                    if ($m[1] == $year) {
                        $seq = str_pad(((int) $m[2]) + 1, 7, '0', STR_PAD_LEFT);
                    }
                }

                $insuranceNo = "RB-{$year}-{$seq}";

                // Determine ISE No
                $iseNo = ($userLevel === 'INSURANCE STAFF') 
                    ? $userId 
                    : ($request->filled('iseno') ? $request->input('iseno') : null);

                // ----------------------------
                // D) INSERT INSURANCE RECORD
                // ----------------------------
                RenewalBusinessTransaction::create([
                    'Insurance_No'      => $insuranceNo,
                    'Gross_Premium'     => (float) $request->input('grosspremium', 0),
                    'Net_Rem'           => (float) $request->input('netremittance', 0),
                    'Commission'        => (float) $request->input('commission', 0),
                    'Option_Type'       => $request->input('optiontype', 'PAID'),
                    'Install_Pay'       => (int) $request->input('chkpayment', 0),
                    'Month_Terms'       => $request->input('terms', ''),
                    'Month_Pay'         => (float) $request->input('monthpay', 0),
                    'Insurance_Type'    => $request->input('instype', ''),
                    'Insurance_Company' => $request->input('insco', ''),
                    'Start_Date'        => $request->input('startdate'),
                    'Policy_No'         => $request->input('policyno', ''),
                    'Issue_Date'        => $request->input('issuedate'),
                    'Policy_Expiration' => $request->input('pexpiredate'),
                    'Mortgage'          => $request->input('mortgage', ''),
                    'Customer_No'       => $custNo,
                    'VIN'               => $vin,
                    'Trans_Date'        => now(),
                    'ISE_No'            => $iseNo,
                    'User_ID'           => $userId,
                ]);

                // ----------------------------
                // E) INSERT PAYMENTS
                // ----------------------------
                foreach ($payments as $p) {
                    $pdcDate = (!empty($p['PDC_Date']) && strtotime($p['PDC_Date']) !== false)
                        ? Carbon::parse($p['PDC_Date'])->format('Y-m-d')
                        : null;

                    TransactionRBPayment::create([
                        'Insurance_No'     => $insuranceNo,
                        'User_ID'          => $userId,
                        'Payment_Type'     => $p['Payment_Type'] ?? null,
                        'EWallet_Type'     => $p['EWallet_Type'] ?? null,
                        'PDC_No'           => $p['PDC_No'] ?? null,
                        'PDC_Account_Name' => $p['PDC_Account_Name'] ?? null,
                        'PDC_Bank_Name'    => $p['PDC_Bank_Name'] ?? null,
                        'PDC_Date'         => $pdcDate,
                        'Payment_Terms'    => $p['Payment_Terms'] ?? null,
                        'Payment_Amount'   => isset($p['Payment_Amount']) ? (float) $p['Payment_Amount'] : null,
                        'Payment_Date'     => now(),
                    ]);
                }

                // ----------------------------
                // F) CREATE NOTIFICATION
                // ----------------------------
                $custName = $request->input('custname');

                Notification::create([
                    'Insurance_No'     => $insuranceNo,
                    'Business_Type'    => 'RENEWAL BUSINESS',
                    'Insurance_Status' => 'PENDING',
                    'Title'            => "[Renewal Business Insurance - {$insuranceNo}]",
                    'Message'          => "{$custName} created a new request",
                    'Info_Type'        => 'info',
                    'URL'              => 'renewal_business_modify',
                    'Status'           => 'unread',
                    'Created_Date'     => now(),
                    'User_ID'          => $userId,
                ]);

                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $insuranceNo,
                ]);
            });

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Update existing transaction status and net remittance info.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function updateNetRemittance(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceno'   => 'required|string',
            'insgpremium'   => 'nullable|numeric',
            'netrem'        => 'nullable|numeric',
            'inscommission' => 'nullable|numeric',
        ]);

        try {
            // 2. Database Transaction
            return DB::transaction(function () use ($validated) {
                
                $insuranceNo = $validated['insuranceno'];

                // 3. Update existing transaction record using Eloquent
                $updated = TransactionRb::where('Insurance_No', $insuranceNo)
                    ->update([
                        'Gross_Premium' => $validated['insgpremium'] ?? '',
                        'Net_Rem'       => $validated['netrem'] ?? '',
                        'Net_Rem_Date'  => now(),
                        'Commission'    => $validated['inscommission'] ?? '',
                        'User_ID'       => Auth::id(),
                    ]);

                if (!$updated) {
                    return response()->json([
                        'result'  => 0,
                        'message' => 'Transaction record not found.',
                    ], 404);
                }

                // 4. Return successful response
                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $insuranceNo,
                ]);
            });

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Get transaction details by Insurance Number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTransactionsRb(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceNo' => 'nullable|string',
        ]);

        $data = [];

        // 2. Query Record using Eloquent if parameter is supplied
        if (!empty($validated['insuranceNo'])) {
            $data = TransactionRb::where('Insurance_No', $validated['insuranceNo'])->get();
        }

        // 3. Return JSON Response
        return response()->json($data);
    }

    public function getRenewBusinessPayment(Request $request)
    {
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json(['data' => []]);
        }

        // Fetch matching records via Eloquent
        $payments = TransactionRBPayment::where('Insurance_No', $insuranceNo)->get();

        // Transform the collection to attach row index ('urutan') and action buttons
        $data = $payments->values()->map(function ($row, $index) {
            $payId = e($row->Payment_ID);

            // Use attributesToArray() instead of toArray() to avoid circular reference loops
            return array_merge($row->attributesToArray(), [
                'urutan' => $index + 1,
                'button' => '<label payid="' . $payId . '" class="btn btn-success btn-action btnremovepaysave" data-toggle="tooltip" data-placement="top" title="Remove">'
                        . '<i class="fa-regular fa-trash-can"></i>'
                        . '</label>',
            ]);
        });

        return response()->json(['data' => $data]);
    }

    /**
     * Delete a transaction record by Insurance Number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTransaction(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceno' => 'required|string',
        ]);

        try {
            // 2. Perform deletion using Eloquent
            $deletedCount = TransactionRb::where('Insurance_No', trim($validated['insuranceno']))->delete();

            // 3. Check if record was deleted
            if ($deletedCount > 0) {
                return response()->json([
                    'result' => 1
                ]);
            }

            return response()->json([
                'result' => 0,
                'error'  => 'No matching record found'
            ], 404);

        } catch (Exception $e) {
            // Log error internally automatically managed by Laravel logging
            return response()->json([
                'result' => 0,
                'error'  => 'Database error occurred'
            ], 500);
        }
    }       
    
    
    /**
     * Get expiring transaction data using Eloquent models and relationships.
     */
    /**
     * Server-side handler for Expiring DataTables.
     */
    public function getExpiringTransactions(Request $request): JsonResponse
    {
        $today = now()->format('Y-m-d');
        $ninetyDaysLater = now()->addDays(90)->format('Y-m-d');

        // 1. Build Query with Joins (Flattened for DataTables searching & sorting)
        $query = TransactionsNb::query()
            ->from('transactions_nb as t')
            ->leftJoin('customer_information as c', 't.Customer_No', '=', 'c.Customer_No')
            ->leftJoin('vehicle_information as v', 't.VIN', '=', 'v.VIN')
            ->leftJoin('vw_insurance_staff as i', 't.ISE_No', '=', 'i.ISE_No')
            ->select([
                't.Insurance_No',
                't.Trans_Date',
                't.Trans_Status',
                't.Customer_No',
                't.VIN',
                't.Insurance_Company',
                't.Option_Type',
                't.Policy_Expiration',
                'c.Full_Name',
                'c.Contact_No',
                'v.CS_No',
                'v.Plate_No',
                'v.Model',
                'v.Variant',
                'i.ISE_Name',
            ])
            ->where(function ($q) use ($today, $ninetyDaysLater) {
                $q->whereBetween('t.Policy_Expiration', [$today, $ninetyDaysLater])
                  ->orWhere('t.Policy_Expiration', '<=', $today);
            });

        $statusColors = [
            'PENDING'            => 'label label-default',
            'IN PROCESS'         => 'label label-primary',
            'COMPLETED'          => 'label label-success',
            'PAYMENT PROCESSING' => 'label label-warning',
            'PAYMENT CONFIRMED'  => 'label label-success',
            'CANCELLED'          => 'label label-danger',
            'PARTIALLY PAID'     => 'label bg-purple',
            'FAILED TO ASSIGN'   => 'label bg-navy',
        ];

        // 2. Return Yajra Server-Side JSON Response
        return DataTables::of($query)
            ->addIndexColumn() // Generates 'DT_RowIndex' (replaces urutan)
            ->editColumn('Trans_Status', function ($row) use ($statusColors) {
                $insuranceNo = e($row->Insurance_No ?? '');
                $statusRaw   = $row->Trans_Status ?? '';
                $status      = strtoupper(trim(preg_replace('/\s+/u', ' ', str_replace("\xC2\xA0", " ", $statusRaw))));
                $labelClass  = $statusColors[$status] ?? 'label label-default';

                return '<span insuranceno="' . $insuranceNo . '" class="badge ' . $labelClass . '">' . e($statusRaw) . '</span>';
            })
            ->rawColumns(['Trans_Status'])
            ->make(true);
    }




    public function renewalBusinessModify(){
        return view("livewire.main.transactions.renewal_business_modify");
    }

    public function getRbTransactionsByInsuranceNo(Request $request): JsonResponse
    {
        $insuranceNo = $request->input('insuranceno');

        if (empty($insuranceNo)) {
            return response()->json([]);
        }

        // Eloquent query matching "SELECT * FROM transactions_nb WHERE Insurance_No = :insuranceno"
        $data = TransactionRb::where('Insurance_No', $insuranceNo)->get();

        return response()->json($data);
    }


    /**
     * Get list of vehicles by Customer Number.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getVehiclesByCustomer(Request $request): JsonResponse
    {
        // 1. Validate request input
        $validated = $request->validate([
            'custno' => 'required|string',
        ]);

        $custNo = trim($validated['custno']);

        // 2. Fetch records using Eloquent
        $vehicles = VehicleInformation::where('Customer_No', $custNo)->get();

        // 3. Process and enrich data
        $data = $vehicles->map(function ($vehicle, $index) {
            $row = $vehicle->toArray();
            $row['urutan'] = $index + 1;
            $row['button'] = ''; // Placeholder matching legacy script
            return $row;
        });

        // 4. Return standard DataTables JSON response
        return response()->json([
            'data' => $data
        ]);
    }


    /**
     * Update transaction status, add to approval status log, and trigger notification.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Request $request): JsonResponse
    {
        // 1. Input Validation
        $validated = $request->validate([
            'insuranceno'    => 'required|string',
            'transstatus'    => 'required|string',
            'transsremarks' => 'nullable|string',
        ]);

        try {
            // 2. Perform operations inside an automated DB Transaction
            return DB::transaction(function () use ($validated) {
                $userId      = Auth::id(); // Get authenticated user's ID
                $insuranceNo = $validated['insuranceno'];
                $transStatus = $validated['transstatus'];
                $remarks     = $validated['transsremarks'] ?? '';

                // A. Update existing transaction status
                TransactionRb::where('Insurance_No', $insuranceNo)->update([
                    'Trans_Status'         => $transStatus,
                    'Trans_Status_Remarks' => $remarks,
                    'Trans_Status_Date'    => now(),
                    'User_ID'              => $userId,
                ]);

                // B. Insert into approval status log
                ApprovalRbStatus::create([
                    'Insurance_No'         => $insuranceNo,
                    'User_ID'              => $userId,
                    'Trans_Status'         => $transStatus,
                    'Trans_Status_Remarks' => $remarks,
                    'Trans_Status_Date'    => now(),
                ]);

                // C. Insert notification log
                Notification::create([
                    'Insurance_No'     => $insuranceNo,
                    'Business_Type'    => 'RENEWAL BUSINESS',
                    'Insurance_Status' => $transStatus,
                    'Title'            => '[' . $transStatus . ' - ' . $insuranceNo . ']',
                    'Message'          => 'The status of the request has been updated.',
                    'Info_Type'        => 'info',
                    'URL'              => 'renewal_business_modify',
                    'Status'           => 'unread',
                    'Created_Date'     => now(),
                    'User_ID'          => $userId,
                ]);

                // D. Return success response
                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $insuranceNo,
                ]);
            });

        } catch (Exception $e) {
            return response()->json([
                'result' => 0,
                'error'  => $e->getMessage(),
            ], 500);
        }
    }



    public function printPdf($insurance_no)
    {
       // 1. Fetch parent record with child payments relationship
        $transaction = TransactionRb::with(['transaction_Rb_payment', 'customer_information', 'insurance_agent'])
            ->where('Insurance_No', $insurance_no)
            ->firstOrFail(); // Ensures a 404 response if record does not exist

        // 2. Load the Blade view and pass variables
        $pdf = Pdf::loadView('livewire.main.pdf.invoice', [
            'transaction' => $transaction,
            'customer_info' => $transaction->customer_information,
            'payments'    => $transaction->transaction_Rb_payment,
            'insurance_agent' => $transaction->insurance_agent,
        ]);


        // 3. Configure paper size and orientation (optional)
        $pdf->setPaper('A4', 'portrait');

        // 4. Stream directly to browser tab ('inline')
        return $pdf->stream("Invoice_{$insurance_no}.pdf");
        
        // Alternatively, use download() to force immediate file download:
        // return $pdf->download("Invoice_{$insurance_no}.pdf");
    }

}
