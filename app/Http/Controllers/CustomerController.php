<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  

use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CustomerInformation;
use App\Models\UploadedCustomer;


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
        // 1. Return an Eloquent Query Builder (do NOT call ->get())
        $query = CustomerInformation::with('vehicle');

        // 2. Handle Alphabetical / Special Character Filter
        // Accepts 'btnselect' or 'letter' from JS payload
        $filter = $request->input('btnselect', $request->input('letter'));

        if (!empty($filter) && $filter !== 'ALL') {
            if ($filter === '[0-9]') {
                // Match names starting with numbers
                $query->whereRaw("Full_Name REGEXP '^[0-9]'");
            } elseif ($filter === '[SPECIAL CHAR]') {
                // Match names starting with non-alphanumeric characters
                $query->whereRaw("Full_Name REGEXP '^[^a-zA-Z0-9]'");
            } else {
                // Match standard A-Z first letter
                $query->where('Full_Name', 'like', "{$filter}%");
            }
        }   


        // Determine and extract the search string safely
        $searchValue = null;
        
        if ($request->filled('searchval')) {
            $searchValue = $request->input('searchval');
        } elseif ($request->has('search') && is_array($request->input('search'))) {
            // Extract the string value from DataTables' search array: ['value' => 'term', 'regex' => false]
            $searchValue = $request->input('search.value');
        } elseif ($request->filled('search') && is_string($request->input('search'))) {
            $searchValue = $request->input('search');
        }

        // Handle global search filter safely using a string value
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('Full_Name', 'like', "%{$searchValue}%")
                ->orWhere('Customer_No', 'like', "%{$searchValue}%")
                ->orWhere('Contact_No', 'like', "%{$searchValue}%")
                ->orWhere('Email_Address', 'like', "%{$searchValue}%");
            });
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
        ->addColumn('button', function ($row) {
            $custNoEscaped = e($row->Customer_No);
            $buttons = '';
            $buttons .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnvehicle" data-toggle="tooltip" title="View Vehicle"><i class="fa fa-car"></i></label> ';
            $buttons .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" data-placement="top" title="View & Modify"><i class="fa fa-edit"></i></label>';
            $buttons .= '<label custno="' . $custNoEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" title="View & Modify"><i class="fa fa-edit"></i></label>';

            return $buttons;
        })
        ->rawColumns(['button'])
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


    public function getCustomerDetails(Request $request)
    {
        $custNo = trim($request->input('custno'));

        if (empty($custNo)) {
            return response()->json([]);
        }

        // 1. Primary Lookup: Active Customer View
        $data = CustomerInformation::where('Upload_Cust_No', $custNo)->get();

        if ($data->isNotEmpty()) {
            $data->transform(function ($item) {
                $item->Cust_Exist = true;
                return $item;
            });

            return response()->json($data);
        }

        // 2. Fallback Lookup: Upload/Staging Table
        $data = UploadedCustomer::where('Customer_No', $custNo)->get();

        $data->transform(function ($item) {
            $item->Cust_Exist = false;
            return $item;
        });

        return response()->json($data);
    }
}
