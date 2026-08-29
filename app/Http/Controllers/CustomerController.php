<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CustomerInformation;


class CustomerController extends Controller
{

    public function index(){ 

        return view('livewire.main.transactions.customers');
    }



    /**
     * Fetch customer data for DataTables AJAX.
    */
    public function getCustomers(Request $request)
    {
        // Querying CustomerInformation model
        $query = CustomerInformation::query();
        
        // Determine the search input (Handles both custom string inputs and DataTables array input)
        $searchValue = null;
        if ($request->filled('searchval')) {
            $searchValue = $request->searchval;
        } elseif ($request->has('search') && is_array($request->search)) {
            $searchValue = $request->input('search.value');
        } elseif ($request->filled('search')) {
            $searchValue = $request->search;
        }

        // Handle global search filter safely
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('Full_Name', 'like', "%{$searchValue}%")
                ->orWhere('Customer_No', 'like', "%{$searchValue}%")
                ->orWhere('Contact_No', 'like', "%{$searchValue}%")
                ->orWhere('Email_Address', 'like', "%{$searchValue}%");
            });
        }   

        // Handle alphabetical filter
        if ($request->filled('letter') && $request->letter !== 'ALL') {
            $query->where('Last_Name', 'like', "{$request->letter}%");
        }        

        return DataTables::of($query)
        ->addIndexColumn()
        ->setRowId('Customer_No')
        ->editColumn('Birth_Date', function ($row) {
            return !empty($row->Birth_Date) 
                ? \Carbon\Carbon::parse($row->Birth_Date)->format('d-M-Y') 
                : '';
        })
        ->editColumn('Active_Status', function ($row) {
            return ($row->Active_Status == '1' || strtoupper($row->Active_Status) === 'ACTIVE') 
                ? 'ACTIVE' 
                : 'INACTIVE';
        })
        ->addColumn('action', function ($row) {
            $custNoEscaped = e($row->Customer_No);
            $button  = '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnvehicle" data-toggle="tooltip" title="View Vehicle"><i class="fa fa-car"></i></label> ';
            $button .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" data-placement="top" title="View & Modify"><i class="fa fa-edit"></i></label>';
            $button .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" title="View & Modify"><i class="fa fa-edit"></i></label>';

            return $button;
        })
        ->rawColumns(['action'])
        ->make(true);
    }


    /**
     * Fetch customer data for DataTables AJAX.
    */
    public function show($custno)
    {
        $customer = CustomerInformation::where('Customer_No', $custno)->firstOrFail();
        return response()->json($customer);
    }


    /**
     * Store new customer.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_no' => 'required|unique:customers,customer_no',
            'group'       => 'required|string',
            'first_name'  => 'nullable|string',
            'last_name'   => 'nullable|string',
            'full_name'   => 'required|string',
            'email'       => 'required|email',
            'contact_no'  => 'required|string',
        ]);

        $customer = CustomerInformation::create($validated);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    
    /**
     * Show single customer for edit modal.
     */
    // public function show(CustomerInformation $customer)
    // {
    //     return response()->json($customer);
    // }


    /**
     * Update customer.
     */
    public function update(Request $request, CustomerInformation $customer)
    {
        $validated = $request->validate([
            'group'      => 'required|string',
            'full_name'  => 'required|string',
            'email'      => 'required|email',
            'contact_no' => 'required|string',
        ]);

        $customer->update($validated);

        return response()->json(['success' => true, 'data' => $customer]);
    }

    /**
     * Delete customer.
     */
    public function destroy(CustomerInformation $customer)
    {
        $customer->delete();

        return response()->json(['success' => true]);
    }
}
