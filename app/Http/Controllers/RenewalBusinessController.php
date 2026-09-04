<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\NewBusiness;
use App\Models\User;


class RenewalBusinessController extends Controller
{
    public function index(){
        return view('livewire.main.transactions.renewal_business');
    }

    public function getRenewalData(Request $request)
    {
        // Inputs & Filters
        $viewPending  = filter_var($request->input('viewpending'), FILTER_VALIDATE_BOOLEAN);
        $viewExpiring = filter_var($request->input('viewexpiring'), FILTER_VALIDATE_BOOLEAN);
        $searchVal    = trim($request->input('searchval', ''));
        $dateFrom     = $request->input('datefrom');
        $dateTo       = $request->input('dateto');
        $chkAll       = (int) $request->input('chkall', 0);

        // Base Query with Left Joins
        $query = DB::table('transactions_rb as t')
            ->select([
                't.Insurance_No',
                't.Trans_Date',
                't.Trans_Status',
                'v.Order_No',
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
                DB::raw('COALESCE(a.Call_Attempts, 0) AS Call_Attempts'),
                't.Option_Type'
            ])
            ->leftJoin('customer_information as c', 't.Customer_No', '=', 'c.Customer_No')
            ->leftJoin('vehicle_information as v', 't.VIN', '=', 'v.VIN')
            ->leftJoin('vw_insurance_staff as i', 't.ISE_No', '=', 'i.ISE_No')
            ->leftJoin('vw_call_attempts_rb as a', 't.Insurance_No', '=', 'a.Insurance_No');

        // Dynamic Filtering
        if ($viewPending) {
            $query->where('t.Trans_Status', 'PENDING');
        } elseif ($viewExpiring) {
            $today = Carbon::today()->toDateString();
            $ninetyDaysOut = Carbon::today()->addDays(90)->toDateString();
            $query->whereBetween('t.Policy_Expiration', [$today, $ninetyDaysOut]);
        } elseif (!empty($searchVal)) {
            $query->where(function ($q) use ($searchVal) {
                $q->where('t.Insurance_No', 'LIKE', "%{$searchVal}%")
                ->orWhere('t.VIN', 'LIKE', "%{$searchVal}%")
                ->orWhere('v.Order_No', 'LIKE', "%{$searchVal}%")
                ->orWhere('v.CS_No', 'LIKE', "%{$searchVal}%")
                ->orWhere('v.Plate_No', 'LIKE', "%{$searchVal}%")
                ->orWhere('v.Customer_No', 'LIKE', "%{$searchVal}%")
                ->orWhere('c.Full_Name', 'LIKE', "%{$searchVal}%");
            });
        } elseif ($chkAll === 0 && $this->isValidDate($dateFrom) && $this->isValidDate($dateTo)) {
            $query->whereBetween(DB::raw('DATE(t.Trans_Date)'), [$dateFrom, $dateTo]);
        }

        // Execution & Sorting
        $records = $query->orderBy('t.Trans_Date', 'DESC')->get();

        // Process data formatting for output
        $statusColors = [
            'PENDING'   => 'label label-default',
            'RENEWED'   => 'label label-primary',
            'CANCELLED' => 'label label-danger',
        ];

        $data = $records->map(function ($row, $index) use ($statusColors) {
            $insuranceNo = e($row->Insurance_No);

            // Normalize status string
            $statusRaw = $row->Trans_Status ?? '';
            $status    = strtoupper(trim($statusRaw));
            $status    = preg_replace('/\s+/u', ' ', $status);
            $status    = str_replace("\xC2\xA0", ' ', $status);

            // Assign CSS label class
            $labelClass = $statusColors[$status] ?? 'label label-default';

            // HTML Trans Status Badge
            $statusHtml = '<span insuranceno="' . $insuranceNo . '" class="badge ' . $labelClass . '">' . e($statusRaw) . '</span>';

            // Action Buttons
            $buttons = '';
            if ($row->Option_Type === 'PAID') {
                $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnpay" data-toggle="tooltip" title="Payment"><i class="fa-solid fa-peso-sign"></i></label>';
            }
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnnetrem" data-toggle="tooltip" title="Gross Premium / Net Rem"><i class="fa-solid fa-money-bill-transfer"></i></label>';
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnstatus" data-toggle="tooltip" title="Change Status"><i class="fa-solid fa-chart-bar"></i></label>';
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btncall" data-toggle="tooltip" title="View & Call"><i class="fa-solid fa-phone"></i></label>';
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btncalllog" data-toggle="tooltip" title="View Call Logs"><i class="fa-solid fa-volume-control-phone"></i></label>';
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" title="View & Modify"><i class="fa fa-edit"></i></label>';
            $buttons .= '<label insuranceno="' . $insuranceNo . '" class="btn btn-success btn-action btndelete" data-toggle="tooltip" title="Delete"><i class="fa-regular fa-trash-can"></i></label>';

            // Convert record to array & add row-specific data
            $itemArray = (array) $row;
            $itemArray['Trans_Status'] = $statusHtml;
            $itemArray['urutan']       = $index + 1;
            $itemArray['button']       = $buttons;

            return $itemArray;
        });

        return response()->json(['data' => $data]);
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
        
}
