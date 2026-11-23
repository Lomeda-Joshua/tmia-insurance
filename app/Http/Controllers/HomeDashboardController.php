<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

use App\Models\RenewalBusinessTransaction;
use App\Models\User;

use App\Models\CallStatus;
use App\Models\NewBusiness;
use App\Models\TransactionRb;
use App\Models\TransactionsNb;
use App\Models\CustomerInformation;
use App\Models\ApprovalNbStatus;
use App\Models\ApprovalRbStatus;

use Illuminate\Support\Facades\Auth;
use Exception;


class HomeDashboardController extends Controller
{
    public function index(){

        $today = Carbon::now('Asia/Manila');

        if( Auth::user()->User_ID != 1 ){
            $auth_account = 'ISE_No';
            $current_user = Auth::user()->User_ID;
        }else if(Auth::user()->User_ID == 1){
            $auth_account = 'User_ID';
            $current_user = 1;
        }
        
        $newBusinessPendingCount = NewBusiness::where('Trans_Status', 'PENDING')->where($auth_account,$current_user)->count();
        $renewalBusinessPendingCount = TransactionRb::where('Trans_Status', 'PENDING')->where($auth_account,$current_user)->count();

        $renewedPolicies = TransactionRb::where('Trans_Status', 'RENEWED')->where($auth_account,$current_user)->count();
        $completedPolicies = TransactionsNb::where('Trans_Status', 'COMPLETED')->where($auth_account,$current_user)->count();
        
        $ise_staff = User::where('User_Level_ID', 7)
            ->withCount(['transactionRb as pending_count' => function ($q) {
                $q->where('Trans_Status', 'PENDING');}])
            ->get();

        $birthdaysThisMonth = CustomerInformation::whereMonth('Birth_Date', $today->month)
            ->orderByRaw('DAY(Birth_Date)')
            ->get();


        $approvalStatuses = ApprovalNbStatus::query()
            ->select(
                'Insurance_No',
                'User_ID',
                'Trans_Status',
                'Trans_Status_Remarks',
                'Trans_Status_Date'
            )
            ->selectRaw("'NB' as business_type")
            ->unionAll(
                ApprovalRbStatus::query()
                    ->select(
                        'Insurance_No',
                        'User_ID',
                        'Trans_Status',
                        'Trans_Status_Remarks',
                        'Trans_Status_Date'
                    )
                    ->selectRaw("'RB' as business_type")
            )
            ->get();

        

        return view('livewire.main.home', [
            'birthdaysThisMonth' => $birthdaysThisMonth,
            'ise_staff' => $ise_staff,
            'approvalStatuses' => $approvalStatuses,
            'newBusinessCount' => $newBusinessPendingCount,
            'renewalBusinessCount' => $renewalBusinessPendingCount,
            'renewedPolicies' => $renewedPolicies,
            'completedPolicies' => $completedPolicies,
        ]);
    }
} 
