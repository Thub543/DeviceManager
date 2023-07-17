<?php

namespace App\Http\Requests\EmployeeRequests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeAddRequest extends FormRequest
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
            'firstname' => 'required|max:100|min:2',
            'surname' => 'required|max:100|min:2',
            'personal_number' => 'nullable|max:15|min:2|unique:employees,personal_number',
            'location_id'=> 'required|integer|exists:locations,id',
        ];
    }


    public function messages()
    {
        return [
            'firstname.required' => 'Firstname is required!',
            'firstname.max' => 'Firstname is too long!(max. 100 Chars)',
            'firstname.min' => 'Firstname is too short!(min. 2 Chars)',

            'surname.required' => 'Lastname is required!',
            'surname.max' => 'Firstname is too long!(max. 100 Chars)',
            'surname.min' => 'Firstname is too short!(min. 2 Chars)',

            'personal_number.max' => 'Personal Number is too long!(max. 15 Chars)',
            'personal_number.min' => 'Personal Number is too short!(min. 2 Chars)',

        ];
    }
}
