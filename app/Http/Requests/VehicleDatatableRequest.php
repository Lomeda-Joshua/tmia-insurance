<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class VehicleDatatableRequest extends FormRequest
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
            'searchval' => ['nullable', 'string', 'max:100'],
            'datefrom'  => ['nullable', 'date_format:d-m-Y'],
            'dateto'    => ['nullable', 'date_format:d-m-Y'],
            'chkall'    => ['nullable', 'boolean'],
        ];
    }
}
