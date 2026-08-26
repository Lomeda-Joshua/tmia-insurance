<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vin'              => ['required', 'string', 'max:100'],
            'make'             => ['required', 'string', 'max:100'],
            'model'            => ['required', 'string', 'max:100'],
            'model_year'       => ['required', 'string', 'max:10'],
            'color'            => ['required', 'string', 'max:50'],
            'engine_no'        => ['required', 'string', 'max:100'],
            'cs_no'            => ['required', 'string', 'max:50'],
            'plate_no'         => ['required', 'string', 'max:20'],
            'srp'              => ['required', 'numeric', 'min:0'],
            'vsi_date'         => ['required', 'date'],
            'variant'          => ['required', 'string'],
            'body_type'        => ['required', 'string'],
            'transmission'     => ['required', 'string'],
            'fuel_type'        => ['required', 'string'],
            'seats'            => ['required', 'integer', 'min:1'],
            'prod_class'       => ['required', 'string'],
            'owner_type'       => ['required', 'string'],
            'vehicle_owner'    => ['required', 'string'],
            'marketing_prof'   => ['required', 'string'],
        ];
    }
}
