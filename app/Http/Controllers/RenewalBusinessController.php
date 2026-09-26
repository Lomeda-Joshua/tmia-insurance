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
use App\Models\UploadedCustomer;
use Illuminate\Support\Facades\Auth;
use Exception;

class RenewalBusinessController extends Controller
{
    public function index(){
        return view('livewire.main.transactions.renewal_business');
    }

    public function getRenewalTableData(RenewalBusinessDatatableRequest $request): JsonResponse
    {
        $filters = $request->validated();     
        $query = RenewalBusinessTransaction::with([
                    'customer_details' => function ($q) {$q->select('Customer_No', 'Full_Name', 'Contact_No' ); }, // Select columns from Customer table
                    'vehicle_details' => function ($q) {$q->select('VIN', 'Make', 'Model', 'Plate_No', 'Model_Year', 'Color', 'Engine_No', 'CS_No', 'Customer_No'); } // Select columns from Customer table
            ])->select([
                'Insurance_No',
                'Trans_Date',
                'Trans_Status',
                'VIN',
                'Customer_No', // Foreign key required for mapping
                'Insurance_Company',
            ]);

        
        // 1. Pending Filter (Priority 1)
        if (! empty($filters['viewpending'])) {
            $query->where('Trans_Status', 'PENDING');

        // 2. Expiring Filter (Priority 2)
        } elseif (! empty($filters['viewexpiring'])) {
            $query->whereBetween('Policy_Expiration', [
                now()->startOfDay(),
                now()->addDays(90)->endOfDay(),
            ]);

        // 3. Search Filter (Priority 3)
        } elseif (! empty($filters['searchval'])) {
            $search = '%' . $filters['searchval'] . '%';

            $query->where(function ($q) use ($search) {
                $q->where('Insurance_No', 'like', $search)
                  ->orWhere('VIN', 'like', $search)
                  ->orWhere('CS_No', 'like', $search)
                  ->orWhere('Plate_No', 'like', $search)
                  ->orWhere('Customer_No', 'like', $search)
                  ->orWhere('Full_Name', 'like', $search);
            });

        // 4. Date Range Filter (Priority 4 - Only when chkall is 0/false)
        } elseif (
            empty($filters['chkall']) &&
            ! empty($filters['datefrom']) &&
            ! empty($filters['dateto'])
        ) {
            $query->whereBetween('Trans_Date', [
                Carbon::createFromFormat('d-m-Y', $filters['datefrom'])->startOfDay(),
                Carbon::createFromFormat('d-m-Y', $filters['dateto'])->endOfDay(),
            ]);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn() // Provides DT_RowIndex / urutan
            ->addColumn('button', function ($transaction): string {
                $insuranceNo = e($transaction->Insurance_No);
                $buttons = '';

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
            ->rawColumns(['button'])
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

        
}
