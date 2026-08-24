<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\NewBusiness;
use App\Models\User;


class RenewalBusinessTransactionController extends Controller
{
    public function index(Request $request){
        return view('livewire.main.transactions.renewal_business');
    }

    public function renewalBusinessDatatable(RenewalBusinessDatatableRequest $request): JsonResponse 
    {
        $filters = $request->validated();

        $query = DB::table('transactions_rb as t')
            ->leftJoin(
                'customer_information as c',
                't.Customer_No',
                '=',
                'c.Customer_No'
            )
            ->leftJoin(
                'vehicle_information as v',
                't.VIN',
                '=',
                'v.VIN'
            )
            ->leftJoin(
                'vw_insurance_staff as i',
                't.ISE_No',
                '=',
                'i.ISE_No'
            )
            ->leftJoin(
                'vw_call_attempts_rb as a',
                't.Insurance_No',
                '=',
                'a.Insurance_No'
            )
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
                't.Policy_Expiration',
                'v.Order_No',
                DB::raw('COALESCE(a.Call_Attempts, 0) as Call_Attempts'),
            ]);

        if ($request->boolean('viewpending')) {
            $query->where('t.Trans_Status', 'PENDING');
        } elseif ($request->boolean('viewexpiring')) {
            $query->whereBetween('t.Policy_Expiration', [
                now()->startOfDay()->toDateString(),
                now()->addDays(90)->endOfDay()->toDateString(),
            ]);
        } elseif (! empty($filters['searchval'])) {
            $search = '%' . trim($filters['searchval']) . '%';

            $query->where(function ($query) use ($search) {
                $query
                    ->where('t.Insurance_No', 'like', $search)
                    ->orWhere('t.VIN', 'like', $search)
                    ->orWhere('v.Order_No', 'like', $search)
                    ->orWhere('v.CS_No', 'like', $search)
                    ->orWhere('v.Plate_No', 'like', $search)
                    ->orWhere('v.Customer_No', 'like', $search)
                    ->orWhere('c.Full_Name', 'like', $search);
            });
        } elseif (
            ! empty($filters['datefrom']) &&
            ! empty($filters['dateto'])
        ) {
            $query->whereBetween('t.Trans_Date', [
                Carbon::createFromFormat(
                    'd-m-Y',
                    $filters['datefrom']
                )->startOfDay(),

                Carbon::createFromFormat(
                    'd-m-Y',
                    $filters['dateto']
                )->endOfDay(),
            ]);
        } else {
            $query->whereRaw('1 = 0');
        }

        return DataTables::query($query)
            ->addIndexColumn()
            ->editColumn(
                'Trans_Date',
                fn ($transaction): string => $transaction->Trans_Date
                    ? Carbon::parse($transaction->Trans_Date)
                        ->format('d-M-Y H:i:s')
                    : ''
            )
            ->editColumn(
                'Trans_Status',
                function ($transaction): string {
                    $status = strtoupper(
                        trim((string) $transaction->Trans_Status)
                    );

                    $class = match ($status) {
                        'RENEWED' => 'primary',
                        'CANCELLED' => 'danger',
                        default => 'secondary',
                    };

                    return '<span class="badge text-bg-' . $class . '">'
                        . e($status)
                        . '</span>';
                }
            )
            ->addColumn('button', function ($transaction): string {
                $insuranceNo = e($transaction->Insurance_No);

                $buttons = '';

                if ($transaction->Option_Type === 'PAID') {
                    $buttons .= '<button type="button" '
                        . 'class="btn btn-success btn-action btnpay" '
                        . 'data-insurance-no="' . $insuranceNo . '" '
                        . 'title="Payment">'
                        . '<i class="fa-solid fa-peso-sign"></i>'
                        . '</button>';
                }

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btnnetrem" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="Gross Premium / Net Rem">'
                    . '<i class="fa-solid fa-money-bill-transfer"></i>'
                    . '</button>';

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btnstatus" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="Change Status">'
                    . '<i class="fa-solid fa-chart-bar"></i>'
                    . '</button>';

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btncall" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="View and Call">'
                    . '<i class="fa-solid fa-phone"></i>'
                    . '</button>';

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btncalllog" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="View Call Logs">'
                    . '<i class="fa-solid fa-volume-control-phone"></i>'
                    . '</button>';

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btnedit" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="View and Modify">'
                    . '<i class="fa fa-edit"></i>'
                    . '</button>';

                $buttons .= '<button type="button" '
                    . 'class="btn btn-success btn-action btndelete" '
                    . 'data-insurance-no="' . $insuranceNo . '" '
                    . 'title="Delete">'
                    . '<i class="fa-regular fa-trash-can"></i>'
                    . '</button>';

                return $buttons;
            })
            ->rawColumns(['Trans_Status', 'button'])
            ->setRowId('Insurance_No')
            ->make(true);
    }
}
