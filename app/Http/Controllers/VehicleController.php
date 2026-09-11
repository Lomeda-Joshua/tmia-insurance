<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VehicleDatatableRequest;
use App\Http\Requests\VehicleSaveRequest;
use App\Models\VehicleInformation;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    public function index(){
        return view("livewire.main.transactions.vehicles");
    }

    public function getVehicles(VehicleDatatableRequest $request): JsonResponse
    {
        $filters = $request->validated();        
        $query = VehicleInformation::query()
            ->with(['customer' => function ($q) {
                // Select specific columns from CustomerInformation
                $q->select('Customer_No', 'Full_Name', 'Contact_No');
            }])
            ->select([
                'VIN',
                'Model',
                'Model_Year',
                'Variant',
                'Color',
                'Engine_No',
                'CS_No',
                'Plate_No',
                'VSI_Date',
                'SRP',
                'Customer_No', // 👈 Required foreign key to map relation
                'Owner_Name',
            ]);

            

        // Search Filter
        if (! empty($filters['searchval'])) {
            $search = '%' . $filters['searchval'] . '%';
            $query->where(function ($q) use ($search) {
                $q->where('VIN', 'like', $search)
                  ->orWhere('CS_No', 'like', $search)
                  ->orWhere('Plate_No', 'like', $search)
                  ->orWhere('Customer_No', 'like', $search)
                  ->orWhere('Customer_Name', 'like', $search)
                  ->orWhere('Model', 'like', $search);
            });
        } 
        // Date Range Filter
        elseif (! empty($filters['datefrom']) && ! empty($filters['dateto'])) {
            $query->whereBetween('VSI_Date', [
                Carbon::createFromFormat('d-m-Y', $filters['datefrom'])->startOfDay(),
                Carbon::createFromFormat('d-m-Y', $filters['dateto'])->endOfDay(),
            ]);
        } 
        // Default empty state unless 'All Data' is checked
        elseif (empty($filters['chkall'])) {
            $query->whereRaw('1 = 0');
        }

        // Determine current user level (from Auth model or Session)
        $user = auth()->user();
        $ulevel = $user->User_Level_ID ?? session('User_Level_ID');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('VSI_Date', function ($row): string {
                return $row->VSI_Date ? Carbon::parse($row->VSI_Date)->format('d-M-Y') : '';
            })
            ->editColumn('SRP', function ($row): string {
                return number_format((float) $row->SRP, 2);
            })
            ->addColumn('action', function ($row) use ($ulevel) : string {
                $VINEscaped = e($row->VIN);
                $buttons = '';

                // Assign Vehicle Button (Admin/Insurance Staff only)
                if (in_array((int)$ulevel, [1, 6], true)) {
                    $buttons .= '<label vin="' . $VINEscaped . '" class="btn btn-success btn-action btntag" data-toggle="tooltip" data-placement="top" title="Assign Vehicle"><i class="fa-solid fa-user-tag"></i></label> ';
                }

                // View & Modify Button (All Users)
                $buttons .= '<label vin="' . $VINEscaped . '" class="btn btn-success btn-action btnedit" data-toggle="tooltip" data-placement="top" title="View & Modify"><i class="fa fa-edit"></i></label> ';

                // Delete Vehicle Button (Admin/Insurance Staff only)
                if (in_array((int)$ulevel, [1, 6], true)) {
                    $buttons .= '<label vin="' . $VINEscaped . '" class="btn btn-danger btn-action btndelete" data-toggle="tooltip" data-placement="top" title="Delete Vehicle"><i class="fa fa-remove"></i></label>';
                }

                return $buttons;
            })
            ->rawColumns(['action'])
            ->setRowId('VIN')
            ->make(true);
    }

    public function show(string $vin): JsonResponse
    {
        $vehicle = VehicleInformation::where('VIN', $vin)->firstOrFail();
        return response()->json($vehicle);
    }

    public function storeOrUpdate(VehicleSaveRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $vehicle = VehicleInformation::updateOrCreate(
            ['VIN' => $validated['vin']],
            [
                'Make'                   => $validated['make'],
                'Model'                  => $validated['model'],
                'Year_Model'             => $validated['model_year'],
                'Color'                  => $validated['color'],
                'Engine_No'              => $validated['engine_no'],
                'CS_No'                  => $validated['cs_no'],
                'Plate_No'               => $validated['plate_no'],
                'SRP'                    => $validated['srp'],
                'VSI_Date'               => $validated['vsi_date'],
                'Variant'                => $validated['variant'],
                'Body_Type'              => $validated['body_type'],
                'Power_Transmission'     => $validated['transmission'],
                'Fuel_Type'              => $validated['fuel_type'],
                'Seats'                  => $validated['seats'],
                'Product_Classification' => $validated['prod_class'],
                'Owner_Type'             => $validated['owner_type'],
                'Vehicle_Owner_Name'     => $validated['vehicle_owner'],
                'Marketing_Professional' => $validated['marketing_prof'],
            ]
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Vehicle details saved successfully.',
            'data'    => $vehicle,
        ]);
    }
}
