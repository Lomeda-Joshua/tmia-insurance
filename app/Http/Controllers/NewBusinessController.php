<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewBusinessController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            // Build base query without executing ->get()
            $query = User::select(['User_ID', 'Email_Address']);

            return DataTables::of($query)
                // Maps custom primary key to dt_row_id for DOM manipulation
                ->setRowId('User_ID') 
                
                // Add custom action column (buttons, links)
                ->addColumn('action', function ($row) {
                    $editUrl = route('users.edit', $row->User_ID);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-xs btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    ';
                })
                
                // Flag columns containing HTML strings so they aren't escaped
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('main.new_business');
    }


}
