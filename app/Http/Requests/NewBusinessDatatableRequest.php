<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewBusinessDatatableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->User_ID;
        return [
            'last_name'            => ['required', 'string', 'max:255'],
            'first_name'           => ['required', 'string', 'max:255'],
            'middle_name'          => ['nullable', 'string', 'max:255'],
            'suffix_name'          => ['nullable', 'string', 'max:50'],
            'display_name'         => ['required', 'string', 'max:255'],
            'contact_no'           => ['nullable', 'string', 'max:50'],
            'email'                => ['required', 'email', 'max:255', Rule::unique('users', 'Email_Address')->ignore($userId, 'User_ID')],
            'username'             => ['required', 'string', 'max:255', Rule::unique('users', 'User_Name')->ignore($userId, 'User_ID')],
            'password'             => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_expire_date' => ['nullable', 'date_format:d/m/Y'],
            'enable_2fa'           => ['nullable', 'boolean'],
        ];
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
}
