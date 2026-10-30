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


        $pendingCount = NewBusiness::where('Trans_Status', 'PENDING')->count();


        


        

        return view('livewire.main.home');
    }
}
