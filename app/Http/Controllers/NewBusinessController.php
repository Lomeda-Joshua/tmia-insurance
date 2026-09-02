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
        $filters = $request->validated();    

        $query = NewBusinessTransactionView::query()
            ->select([
                'Insurance_No',
                'Trans_Date',
                'Trans_Status',
                'Customer_No',
                'Full_Name',
                'Contact_No',
                'VIN',
                'CS_No',
                'Plate_No',
                'Model',
                'Variant',
                'Insurance_Company',
                'ISE_Name',
                'MP_Name',
                'Option_Type',
                'Policy_Expiration',
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
            ->editColumn('Trans_Date', function (NewBusinessTransactionView $transaction): string {
                return $transaction->Trans_Date
                    ? Carbon::parse($transaction->Trans_Date)->format('d-M-Y H:i:s')
                    : '';
            })
            ->editColumn('Trans_Status', function (NewBusinessTransactionView $transaction): string {
                $status = strtoupper(trim((string) $transaction->Trans_Status));

                // Modern Bootstrap 5 badge mapping
                $class = match ($status) {
                    'COMPLETED' => 'success',
                    'CANCELLED' => 'danger',
                    'PENDING'   => 'warning',
                    default     => 'secondary',
                };

                return '<span class="badge text-bg-' . $class . '">'
                    . e($status)
                    . '</span>';
            })
            ->addColumn('button', function (NewBusinessTransactionView $transaction): string {
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

                $buttons .= '<button type="button" class="btn btn-sm btn-success btn-action btnedit me-1" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="View and Modify">'
                    . '<i class="fa fa-edit"></i></button>';

                $buttons .= '<button type="button" class="btn btn-sm btn-danger btn-action btndelete" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Delete">'
                    . '<i class="fa-regular fa-trash-can"></i></button>';

                return $buttons;
            })
            ->rawColumns(['Trans_Status', 'button'])
            ->setRowId('Insurance_No')
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
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $userid = $user->id;
            $ulevel = $user->User_Level_Description ?? '';

            /* ============================================================
               1) CUSTOMER INSERT OR UPDATE
               ============================================================ */
            $custno = $request->input('custno');
            $existingCust = CustomerInformation::where('Customer_No', $custno)->first();

            $customerData = [
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

        dd($insuranceNo);

        if (!empty($insuranceNo)) {
            // Using Eloquent ORM
            $data = TransactionNBpayment::where('Insurance_No', $insuranceNo)->get();
            
            // Alternatively, using Query Builder:
            // $data = \DB::table('transactions_nb')->where('Insurance_No', $insuranceNo)->get();
        }

        return response()->json($data);
    }


}
