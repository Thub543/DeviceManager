<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required||min:4|string|max:250|unique:users,username',
            'password' => 'required|min:8|max:250|confirmed',
        ];

    }

    public function messages()
    {
        return [
            'username.required' => 'A username is required',
            'username.max' => 'Username max. 250 characters',
            'username.unqiue' => 'This username already exists',
            'username.min' => 'The password must be at least 4 characters long.',

            'password.max' => 'Max. 250 Chars',
            'password.required' => 'Password is required',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password must be confirmed.'
        ];
    }
}
