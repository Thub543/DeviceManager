<?php

namespace App\Http\Requests\DevicemodelRequests;

use Illuminate\Foundation\Http\FormRequest;

class DevicemodelAddEditRequest extends FormRequest
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
            'model' => 'required|max:50|unique:devicemodels,model,'.$this->route('devicemodel'),
            'vendor' => 'required|max:50',
            'os' => 'nullable|max:50',
            'type_id' => 'required|not_in:default|exists:types,id'
        ];
    }

    public function messages()
    {
        return [
          'model.required' => 'A Model name is required!',
           'model.unique' => 'This Model already exist!',
          'model.max' => 'Max. 50 Chars at Model name',
          'vendor.required' => 'A Vendor is required!',
          'vendor.max' => 'Max. 50 Chars at Vendor name',
          'type_id.required' => 'A Type is required!',
          'type_id.not_in' => 'Please select a valid type!',
          'type_id.exists' => 'Please select a valid type!',

        ];
    }
}
