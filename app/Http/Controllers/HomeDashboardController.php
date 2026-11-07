<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

use App\Models\RenewalBusinessTransaction;

use App\Models\CallStatus;
use App\Models\NewBusiness;


use Illuminate\Support\Facades\Auth;
use Exception;


class HomeDashboardController extends Controller
{
    public function index(){

        $newBusinessCount = NewBusiness::all()->count();
        $pendingCount = NewBusiness::where('Trans_Status', 'PENDING')->count();

        if( $newBusinessCount || $pendingCount != 0 ){
            $pendingOVerallCount = $pendingCount / $newBusinessCount * 100;
        }else {
            $pendingOVerallCount = 0;
        }

        return view('livewire.main.home', [
            "pendingCounts" => $pendingCount, 
            "pendingOVerallCount" => $pendingOVerallCount, 
            "pendingOVerallCounts" => $pendingOVerallCount
        ]);
    }
} 
