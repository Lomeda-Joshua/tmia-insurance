<?php

namespace App\Http\Controllers;

use App\Models\NewBusiness;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; // Add this import

class NewBusinessController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            // Build base query without executing ->get()
            $query = NewBusiness::with(['customerInformation' => function ($q){
                    $q->select('Customer_No');
                }
            ])->select([
                'Insurance_No',
                'Trans_Date',
                'Trans_Status',
                'Customer_No',
                'VIN',
                'Insurance_Company',
                'ISE_No',
                'User_ID'
            ]);

            return DataTables::of($query)
                ->setRowId('Insurance_No')
                ->addIndexColumn() // Generates 'DT_RowIndex' key in output JSON
                ->make(true);
        }

        return view('main.new_business');
    }


}
