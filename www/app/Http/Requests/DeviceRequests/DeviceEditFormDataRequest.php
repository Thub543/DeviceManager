<?php

namespace App\Http\Requests\DeviceRequests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceEditFormDataRequest extends FormRequest
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
            'imei' => 'nullable|numeric|min_digits:15',
            'serial_tag' => 'nullable|max:50',
            'comment' => 'Max:255',
            'warranty' => 'required',
        ];
    }

    public function messages()
    {
        return [

            'IMEI.numeric' => 'IMEI must contain numbers only',
            'IMEI.min_digits' => 'IMEI must have 15 digits',
            'serial_tag.max' => 'Must be only max 50 characters long'
        ];
    }
}
