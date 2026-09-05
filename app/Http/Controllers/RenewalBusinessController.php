<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenewalBusinessDatatableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\RenewalBusinessTransaction;

class RenewalBusinessController extends Controller
{
    public function index(){
        return view('livewire.main.transactions.renewal_business');
    }

    public function getRenewalData(RenewalBusinessDatatableRequest $request): JsonResponse
    {

        $filters = $request->validated();

        dd(RenewalBusinessTransaction::get());

        $query = RenewalBusinessTransaction::query()
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
                'Call_Attempts',
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
        
}
