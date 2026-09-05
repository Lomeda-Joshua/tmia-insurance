<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserRequest extends FormRequest
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
        $userId = $this->input('uid');
        $isNew  = $this->input('appmethod') === 'N';

        return [
            'appmethod'  => ['required', 'string', 'in:N,U'],
            'uid'        => ['nullable', 'required_if:appmethod,U', 'integer'],
            'lname'      => ['required', 'string', 'max:255'],
            'fname'      => ['required', 'string', 'max:255'],
            'mname'      => ['nullable', 'string', 'max:255'],
            'sname'      => ['nullable', 'string', 'max:50'],
            'dname'      => ['required', 'string', 'max:255'],
            'contactno'  => ['nullable', 'string', 'max:50'],
            'email'      => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('user', 'Email_Address')->ignore($userId, 'User_ID')
            ],
            'uname'      => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique('user', 'User_Name')->ignore($userId, 'User_ID')
            ],
            'pword'      => [$isNew ? 'required' : 'nullable', 'string', 'min:6'],
            'ulevel'     => ['required', 'integer'],
            'useractive' => ['required'],
            'regdate'    => ['nullable', 'date'],
            'apprdate'   => ['nullable', 'date'],
            'pwdexpdate' => ['nullable', 'date'],
            'chk2fa'     => ['nullable'],
        ];
    }
}
