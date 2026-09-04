<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RenewalDatatableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'viewpending'  => 'nullable|boolean',
            'viewexpiring' => 'nullable|boolean',
            'searchval'    => 'nullable|string|max:255',
            'datefrom'     => 'nullable|date_format:Y-m-d',
            'dateto'       => 'nullable|date_format:Y-m-d',
            'chkall'       => 'nullable|integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'viewpending'  => filter_var($this->viewpending, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'viewexpiring' => filter_var($this->viewexpiring, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            'chkall'       => (int) $this->chkall,
        ]);
    }
}
