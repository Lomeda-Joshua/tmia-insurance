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

    public function datatable(VehicleDatatableRequest $request): JsonResponse
    {
        $filters = $request->validated();

        $query = VehicleInformation::query()
            ->select([
                'VIN',
                'Model',
                'Year_Model',
                'Variant',
                'Color',
                'Engine_No',
                'CS_No',
                'Plate_No',
                'VSI_Date',
                'SRP',
                'Customer_No',
                'Customer_Name',
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

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->editColumn('VSI_Date', function ($row): string {
                return $row->VSI_Date ? Carbon::parse($row->VSI_Date)->format('d-M-Y') : '';
            })
            ->editColumn('SRP', function ($row): string {
                return number_format((float) $row->SRP, 2);
            })
            ->addColumn('action', function ($row): string {
                $vin = e($row->VIN);
                return '<button type="button" class="btn btn-xs btn-success btnview" data-vin="' . $vin . '" title="View / Edit">'
                    . '<i class="fa fa-edit"></i> View/Modify</button>';
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
