<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PolicyExpirationController extends Controller
{
    /**
     * Map transaction statuses to AdminLTE/Bootstrap badge classes.
     */
    protected array $statusColors = [
        'PENDING'            => 'label label-default',
        'IN PROCESS'         => 'label label-primary',
        'COMPLETED'          => 'label label-success',
        'PAYMENT PROCESSING' => 'label label-warning',
        'PAYMENT CONFIRMED'  => 'label label-success',
        'CANCELLED'          => 'label label-danger',
        'PARTIALLY PAID'     => 'label bg-purple',
        'FAILED TO ASSIGN'   => 'label bg-navy',
    ];

    /**
     * Retrieve transactions with expiring or expired policies.
     */
    public function loadPolicyExpiration(): JsonResponse
    {
        $transactions = DB::table('transactions_nb as t')
            ->leftJoin('customer_information as c', 't.Customer_No', '=', 'c.Customer_No')
            ->leftJoin('vehicle_information as v', 't.VIN', '=', 'v.VIN')
            ->leftJoin('vw_insurance_staff as i', 't.ISE_No', '=', 'i.ISE_No')
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
                't.Option_Type',
                't.Policy_Expiration',
            ])
            ->where(function ($query) {
                $query->whereBetween('t.Policy_Expiration', [now(), now()->addDays(90)])
                      ->orWhere('t.Policy_Expiration', '<=', now());
            })
            ->orderBy('t.Policy_Expiration', 'asc')
            ->get();

        $formattedData = $transactions->map(function ($row, $index) {
            $rowArray = (array) $row;
            
            $insuranceNo = e($rowArray['Insurance_No']);
            $statusRaw = $rowArray['Trans_Status'] ?? '';
            
            // Normalize status string
            $statusNormalized = Str::upper(trim($statusRaw));
            $statusNormalized = preg_replace('/\s+/u', ' ', $statusNormalized);
            $statusNormalized = str_replace("\xC2\xA0", ' ', $statusNormalized);

            $labelClass = $this->statusColors[$statusNormalized] ?? 'label label-default';

            // Transform Trans_Status to HTML badge string
            $rowArray['Trans_Status'] = sprintf(
                '<span insuranceno="%s" class="badge %s">%s</span>',
                $insuranceNo,
                $labelClass,
                e($statusRaw)
            );

            $rowArray['urutan'] = $index + 1;

            return $rowArray;
        });

        return response()->json([
            'data' => $formattedData,
        ]);
    }
}
