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
use App\Models\Notification;
use App\Models\TransactionRb;
use App\Models\TransactionRBPayment;
use App\Models\VehicleInformation;
use Exception;
use Illuminate\Support\Facades\Auth;

class RenewalBusinessController extends Controller
{
    public function index(){
        return view('livewire.main.transactions.renewal_business');
    }

    public function getRenewalData(RenewalBusinessDatatableRequest $request): JsonResponse
    {
        $filters = $request->validated();     
        $query = RenewalBusinessTransaction::with(['customer_details' => function ($q) {
                // $q->select('Customer_No', 'Full_Name', 'Contact_No' ); // Select columns from Customer table
            }])
            ->select([
                'Insurance_No',
                'Trans_Date',
                'Trans_Status',
                'Customer_No', // Foreign key required for mapping
                'VIN',
                // 'CS_No',
                // 'Plate_No',
                // 'Model',
                // 'Variant',
                // 'Insurance_Company',
                // 'ISE_Name',
                // 'MP_Name',
                // 'Call_Attempts',
                // 'Option_Type',
                // 'Policy_Expiration',
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
            ->setRowId('Insurance_No')
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

    public function saveRenewalBusiness(Request $request): JsonResponse
    {
        // Decode JSON payments array early
        $payments = json_decode($request->input('payments'), true);
        if (! is_array($payments)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid JSON data'], 400);
        }

        // Get authenticated user info
        $user = Auth::user();
        $userid = $user->User_ID ?? $user->id ?? session('userid');
        $ulevel = $user->ulevel ?? session('ulevel');

        try {
            return DB::transaction(function () use ($request, $payments, $userid, $ulevel) {

                // ----------------------------
                // 1) CUSTOMER INSERT OR UPDATE
                // ----------------------------
                $custNoInput = $request->input('custno', '');
                $customerData = [
                    'Group'          => $request->input('group', ''),
                    'Full_Name'      => $request->input('custname', ''),
                    'First_Name'     => $request->input('custfname', ''),
                    'Middle_Name'    => $request->input('custmname', ''),
                    'Last_Name'      => $request->input('custlname', ''),
                    'Suffix_Name'    => $request->input('custsname', ''),
                    'Birth_Date'     => $request->filled('birthdate') ? $request->input('birthdate') : null,
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

                $customer = CustomerInformation::where('Customer_No', $custNoInput)->first();

                if ($customer) {
                    $customer->update($customerData);
                    $finalCustNo = $customer->Customer_No;
                } else {
                    $yearc = date('Y');
                    $prefixc = "TMIA-{$yearc}-";

                    $lastCustomer = CustomerInformation::where('Customer_No', 'LIKE', $prefixc . '%')
                        ->lockForUpdate()
                        ->orderBy('Customer_No', 'desc')
                        ->first();

                    $seqc = '0000001';
                    if ($lastCustomer && preg_match('/^TMIA-(\d{4})-(\d{7})$/', $lastCustomer->Customer_No, $mc)) {
                        if ($mc[1] == $yearc) {
                            $seqc = str_pad(intval($mc[2]) + 1, 7, '0', STR_PAD_LEFT);
                        }
                    }

                    $finalCustNo = "TMIA-{$yearc}-{$seqc}";
                    $customerData['Customer_No'] = $finalCustNo;
                    $customerData['Active_Status'] = 1;

                    CustomerInformation::create($customerData);
                }

                // ----------------------------
                // 2) VEHICLE INSERT OR UPDATE
                // ----------------------------
                $vin = $request->input('vin', '');
                $vehicleData = [
                    'Make'           => $request->input('make', ''),
                    'Model'          => $request->input('model', ''),
                    'Model_Year'     => $request->input('modelyear', ''),
                    'Color'          => $request->input('color', ''),
                    'Engine_No'      => $request->input('engineno', ''),
                    'CS_No'          => $request->input('csno', ''),
                    'Plate_No'       => $request->input('plateno', ''),
                    'SRP'            => floatval($request->input('paidprice', 0)),
                    'VSI_Date'       => $request->filled('vsidate') ? $request->input('vsidate') : null,
                    'Released_Date'  => $request->filled('reldate') ? $request->input('reldate') : null,
                    'Technical_Date' => $request->filled('techdate') ? $request->input('techdate') : null,
                    'Variant'        => $request->input('variant', ''),
                    'Body_Type'      => $request->input('bodytype', ''),
                    'Transmission'   => $request->input('transmission', ''),
                    'Fuel_Type'      => $request->input('fueltype', ''),
                    'Seats'          => $request->input('seats', ''),
                    'Prod_Classify'  => $request->input('prodclass', ''),
                    'Owner_Type'     => $request->input('owntype', ''),
                    'Owner_Name'     => $request->input('voname', ''),
                    'MP_Name'        => $request->input('mpname', ''),
                    'Customer_No'    => $finalCustNo,
                ];

                VehicleInformation::updateOrCreate(
                    ['VIN' => $vin],
                    $vehicleData
                );

                // ----------------------------
                // 3) GENERATE INSURANCE NUMBER
                // ----------------------------
                $year = date('Y');
                $prefix = "RB-{$year}-";

                $lastInsurance = RenewalBusinessTransaction::where('Insurance_No', 'LIKE', $prefix . '%')
                    ->lockForUpdate()
                    ->orderBy('Insurance_No', 'desc')
                    ->first();

                $seq = '0000001';
                if ($lastInsurance && preg_match('/^RB-(\d{4})-(\d{7})$/', $lastInsurance->Insurance_No, $m)) {
                    if ($m[1] == $year) {
                        $seq = str_pad(intval($m[2]) + 1, 7, '0', STR_PAD_LEFT);
                    }
                }

                $insuranceno = "RB-{$year}-{$seq}";

                // ----------------------------
                // 4) INSERT INSURANCE RECORD
                // ----------------------------
                $iseno = ($ulevel === 'INSURANCE STAFF') 
                    ? $userid 
                    : ($request->filled('iseno') ? $request->input('iseno') : null);

                RenewalBusinessTransaction::create([
                    'Insurance_No'      => $insuranceno,
                    'Gross_Premium'     => floatval($request->input('grosspremium', 0)),
                    'Net_Rem'           => floatval($request->input('netremittance', 0)),
                    'Commission'        => floatval($request->input('commission', 0)),
                    'Option_Type'       => $request->input('optiontype', 'PAID'),
                    'Install_Pay'       => intval($request->input('chkpayment', 0)),
                    'Month_Terms'       => $request->input('terms', ''),
                    'Month_Pay'         => floatval($request->input('monthpay', 0)),
                    'Insurance_Type'    => $request->input('instype', ''),
                    'Insurance_Company' => $request->input('insco', ''),
                    'Start_Date'        => $request->filled('startdate') ? $request->input('startdate') : null,
                    'Policy_No'         => $request->input('policyno', ''),
                    'Issue_Date'        => $request->filled('issuedate') ? $request->input('issuedate') : null,
                    'Policy_Expiration' => $request->filled('pexpiredate') ? $request->input('pexpiredate') : null,
                    'Mortgage'          => $request->input('mortgage', ''),
                    'Customer_No'       => $finalCustNo,
                    'VIN'               => $vin,
                    'Trans_Date'        => now(),
                    'ISE_No'            => $iseno,
                    'User_ID'           => $userid,
                ]);

                // ----------------------------
                // 5) INSERT PAYMENTS
                // ----------------------------
                foreach ($payments as $p) {
                    $pdcDate = (! empty($p['PDC_Date']) && strtotime($p['PDC_Date']) !== false)
                        ? date('Y-m-d', strtotime($p['PDC_Date']))
                        : null;

                    TransactionRBPayment::create([
                        'Insurance_No'     => $insuranceno,
                        'User_ID'          => $userid,
                        'Payment_Type'     => $p['Payment_Type'] ?? null,
                        'EWallet_Type'     => $p['EWallet_Type'] ?? null,
                        'PDC_No'           => $p['PDC_No'] ?? null,
                        'PDC_Account_Name' => $p['PDC_Account_Name'] ?? null,
                        'PDC_Bank_Name'    => $p['PDC_Bank_Name'] ?? null,
                        'PDC_Date'         => $pdcDate,
                        'Payment_Terms'    => $p['Payment_Terms'] ?? null,
                        'Payment_Amount'   => isset($p['Payment_Amount']) ? floatval($p['Payment_Amount']) : null,
                        'Payment_Date'     => now(),
                    ]);
                }

                // ----------------------------
                // 6) INSERT NOTIFICATION
                // ----------------------------
                $custName = $request->input('custname', '');
                Notification::create([
                    'Insurance_No'     => $insuranceno,
                    'Business_Type'    => 'RENEWAL BUSINESS',
                    'Insurance_Status' => 'PENDING',
                    'Title'            => '[Renewal Business Insurance - ' . $insuranceno . ']',
                    'Message'          => $custName . ' created a new request',
                    'Info_Type'        => 'info',
                    'URL'              => 'renewal_business_modify',
                    'Status'           => 'unread',
                    'Created_Date'     => now(),
                    'User_ID'          => $userid,
                ]);

                return response()->json([
                    'result'       => 1,
                    'Insurance_No' => $insuranceno,
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
