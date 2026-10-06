<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

use App\Models\RenewalBusinessTransaction;

use Illuminate\Support\Facades\Auth;
use Exception;


class HomeDashboardController extends Controller
{
    public function index(){


        $query = RenewalBusinessTransaction::query()
                ->leftJoin('customer_information', 'transactions_rb.Customer_No', '=', 'customer_information.Customer_No')
                ->leftJoin('vehicle_information', 'transactions_rb.VIN', '=', 'vehicle_information.VIN') // Adjust join key if using CS_No\
                ->leftJoin('user', 'transactions_rb.User_ID', '=', 'user.User_ID') 
                ->leftJoin('user as ise_name', 'transactions_rb.ISE_No', '=', 'ise_name.User_ID')
                ->leftJoin('vw_call_attempts_rb', 'vw_call_attempts_rb.Insurance_No', '=', 'transactions_rb.Insurance_No')
                ->select([
                    // Primary table columns (prefixed to avoid ambiguous column collisions)
                    'transactions_rb.Insurance_No',
                    'transactions_rb.Trans_Date',
                    'transactions_rb.Trans_Status',
                    'transactions_rb.VIN',
                    'transactions_rb.Customer_No',
                    'transactions_rb.Insurance_Company',
                    'transactions_rb.Option_Type',
                    'transactions_rb.Policy_Expiration',
                    'transactions_rb.ISE_No',

                    'ise_name.Display_Name as ise_name',

                    // Columns from Related Tables (Flattened directly for DataTables)
                    'customer_information.Full_Name',
                    'customer_information.Contact_No',

                    'vehicle_information.CS_No',
                    'vehicle_information.Plate_No',
                    'vehicle_information.Make',
                    'vehicle_information.Model',
                    'vehicle_information.Model_Year',
                    'vehicle_information.Variant',

                    'vw_call_attempts_rb.Call_Attempts'
            ])->get();

        return view('livewire.main.home');
    }
}
