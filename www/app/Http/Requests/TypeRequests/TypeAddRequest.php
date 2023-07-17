<?php

namespace App\Http\Requests\TypeRequests;

use Illuminate\Foundation\Http\FormRequest;

class TypeAddRequest extends FormRequest
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
            'type_name' => 'required|max:50',
            'type_initials' => 'required|size:3|unique:types,type_initials',
            'isStationary' => 'nullable'
        ];

    }

    public function messages()
    {
        return [
            'type_name.required' => 'Type name is required',
            'type_name.max' => 'Max 50chars at Name',

            'type_initials.required' => 'Initials is required',
            'type_initials.size' => 'The initials value must be 3 characters long',
            'type_initials.unique' => 'The initials must be unique!'
        ];
    }
}
