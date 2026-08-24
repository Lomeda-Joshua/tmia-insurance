<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RenewalBusinessDatatableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'viewpending' => filter_var(
                $this->input('viewpending', false),
                FILTER_VALIDATE_BOOLEAN
            ),
            'viewexpiring' => filter_var(
                $this->input('viewexpiring', false),
                FILTER_VALIDATE_BOOLEAN
            ),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'viewpending' => ['nullable', 'boolean'],
            'viewexpiring' => ['nullable', 'boolean'],
            'searchval' => ['nullable', 'string', 'max:100'],
            'datefrom' => ['nullable', 'date_format:d-m-Y'],
            'dateto' => [
                'nullable',
                'date_format:d-m-Y',
                'after_or_equal:datefrom',
            ],
        ];
    }


}
