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
        $query = CustomerInformation::query();

        if ($request->filled('search')) {
            $query->where('full_name', 'like', "%{$request->search}%")
                  ->orWhere('customer_no', 'like', "%{$request->search}%");
        }

        if ($request->filled('letter') && $request->letter !== 'ALL') {
            $query->where('full_name', 'like', "{$request->letter}%");
        }

        return DataTables::of($query)
            ->editColumn('birth_date', fn($row) => $row->birth_date?->format('d-M-Y'))
            ->editColumn('status', fn($row) => $row->is_active ? 'ACTIVE' : 'INACTIVE')
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-primary btn-edit" data-id="'.$row->id.'">Edit</button>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="'.$row->id.'">Delete</button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
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
    public function show(CustomerInformation $customer)
    {
        return response()->json($customer);
    }

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
