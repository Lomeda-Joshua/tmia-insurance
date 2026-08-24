<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->User_Level_ID === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->input('uid');

         return [
            'uid' => ['nullable', 'integer'],

            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'mname' => ['nullable', 'string', 'max:100'],
            'sname' => ['nullable', 'string', 'max:100'],
            'dname' => ['required', 'string', 'max:100'],

            'contactno' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:60'],

            'uname' => [
                'required',
                'string',
                'max:30',
                Rule::unique('user', 'User_Name')->ignore($userId, 'User_ID'),
            ],

            'pword' => [
                $userId ? 'nullable' : 'required',
                'string',
                'min:12',
            ],

            'ulevel' => [
                'required',
                'integer',
                'exists:user_level,User_Level_ID',
            ],

            'useractive' => [
                'required',
                Rule::in(['YES', 'NO']),
            ],

            'pwdexpdate' => [
                'nullable',
                'date_format:d/m/Y',
            ],

            'chk2fa' => [
                'required',
                Rule::in(['YES', 'NO']),
            ],
        ];
    }
}
