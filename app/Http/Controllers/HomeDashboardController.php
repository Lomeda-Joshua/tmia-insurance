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
use App\Models\CustomerInformation;

use Illuminate\Support\Facades\Auth;
use Exception;


class HomeDashboardController extends Controller
{
    public function index(){

        $today = Carbon::now('Asia/Manila');

        $newBusinessCount = NewBusiness::all()->count();
        $pendingCount = NewBusiness::where('Trans_Status', 'PENDING')->count();

        if( $newBusinessCount || $pendingCount != 0 ){
            $pendingOVerallCount = $pendingCount / $newBusinessCount * 100;
        }else {
            $pendingOVerallCount = 0;
        }   

        $ise_staff = User::where('User_Level_ID', 7)
            ->withCount(['transactionRb as pending_count' => function ($q) {
                $q->where('Trans_Status', 'PENDING');
            }])
            ->get();

        $birthdaysThisMonth = CustomerInformation::whereMonth('Birth_Date', $today->month)
            ->orderByRaw('DAY(Birth_Date)')
            ->get();

        return view('livewire.main.home', [
            "pendingCounts" => $pendingCount, 
            "pendingOVerallCount" => $pendingOVerallCount, 
            "pendingOVerallCounts" => $pendingOVerallCount,
            'birthdaysThisMonth' => $birthdaysThisMonth,
            "ise_staff" => $ise_staff
        ]);
    }
} 
