<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBusinessDatatableRequest;
use App\Models\NewBusinessTransactionView;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Models\NewBusiness;
use App\Models\InsuranceStaff;

class NewBusinessController extends Controller
{
    public function index(NewBusinessDatatableRequest $request){
        return view('livewire.main.new_business');
    }


    public function newBusinessDatatable(NewBusinessDatatableRequest $request): JsonResponse
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

            if ($request->boolean('viewpending')) {
                $query->where('Trans_Status', 'PENDING');
            } elseif ($request->boolean('viewexpiring')) {
                $query->whereBetween('Policy_Expiration', [
                    now()->startOfDay(),
                    now()->addDays(90)->endOfDay(),
                ]);
            } elseif (! empty($filters['searchval'])) {
                $search = '%' . $filters['searchval'] . '%';

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('Insurance_No', 'like', $search)
                        ->orWhere('VIN', 'like', $search)
                        ->orWhere('CS_No', 'like', $search)
                        ->orWhere('Plate_No', 'like', $search)
                        ->orWhere('Customer_No', 'like', $search)
                        ->orWhere('Full_Name', 'like', $search);
                });
            } elseif (
                ! empty($filters['datefrom']) &&
                ! empty($filters['dateto'])
            ) {
                $query->whereBetween('Trans_Date', [
                    Carbon::createFromFormat('d-m-Y', $filters['datefrom'])
                        ->startOfDay(),

                    Carbon::createFromFormat('d-m-Y', $filters['dateto'])
                        ->endOfDay(),
                ]);
            } else {
                $query->whereRaw('1 = 0');
            }


            return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('Trans_Date', function (NewBusinessTransactionView $transaction): string {
                return $transaction->Trans_Date
                    ? Carbon::parse($transaction->Trans_Date)->format('d-M-Y H:i:s')
                    : '';
            })
            ->editColumn('Trans_Status', function (NewBusinessTransactionView $transaction): string {
                $status = strtoupper(trim((string) $transaction->Trans_Status));

                $class = match ($status) {
                    'COMPLETED' => 'success',
                    'CANCELLED' => 'danger',
                    default => 'secondary',
                };

                return '<span class="badge text-bg-' . $class . '">'
                    . e($status)
                    . '</span>';
            })
            ->addColumn('button', function (NewBusinessTransactionView $transaction): string {
                $insuranceNo = e($transaction->Insurance_No);

                $buttons = '';

                if ($transaction->Option_Type === 'PAID') {
                    $buttons .= '<button type="button" class="btn btn-success btn-action btnpay" '
                        . 'data-insurance-no="' . $insuranceNo . '" title="Payment">'
                        . '<i class="fa-solid fa-peso-sign"></i></button>';
                }

                $buttons .= '<button type="button" class="btn btn-success btn-action btnnetrem" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Gross Premium / Net Rem">'
                    . '<i class="fa-solid fa-money-bill-transfer"></i></button>';

                $buttons .= '<button type="button" class="btn btn-success btn-action btnstatus" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Change Status">'
                    . '<i class="fa-solid fa-chart-bar"></i></button>';

                $buttons .= '<button type="button" class="btn btn-success btn-action btnedit" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="View and Modify">'
                    . '<i class="fa fa-edit"></i></button>';

                $buttons .= '<button type="button" class="btn btn-success btn-action btndelete" '
                    . 'data-insurance-no="' . $insuranceNo . '" title="Delete">'
                    . '<i class="fa-regular fa-trash-can"></i></button>';

                return $buttons;
            })
            ->rawColumns(['Trans_Status', 'button'])
            ->setRowId('Insurance_No')
            ->make(true);


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

    
    public function insuranceStaff(): JsonResponse
    {
        $staff = InsuranceStaff::query()
            ->orderBy('ISE_Name')
            ->get([
                'ISE_No',
                'ISE_Name',
            ]);

        return response()->json($staff);
    }

    public function customers(CustomerListRequest $request): JsonResponse
    {
        // Customer list.
    }

    public function vehicles(VehicleListRequest $request): JsonResponse
    {
        // Vehicle list for selected customer.
    }

    public function payments(NewBusinessPaymentRequest $request): JsonResponse
    {
        // Payment list.
    }

    public function callLogs(NewBusinessCallLogRequest $request): JsonResponse
    {
        
    }

}
