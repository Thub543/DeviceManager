<?php

namespace App\Http\Requests\DeviceRequests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceCreateFormRequest extends FormRequest
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
            'deviceCount' => 'required|integer|min:1',
            'orderid' => 'required|max:50',
            'orderdate' => 'required',
            'warranty' => 'required',
            'ddStatus' => 'required|not_in:default',
            'ddType' => 'required|not_in:default',
            'ddModel' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'deviceCount.required' => 'Amount field must be filled!',
            'orderid.required' => 'OrderID is required!',
            'orderid.max' => 'OrderID can only 50 chars long',
            'orderdate.required' => 'Order Date is required!',
            'ddStatus.requried' => 'Status is required!',
            'ddStatus.not_in' => 'A valid status must be selected!',
            'ddType.requried' => 'Status is required!',
            'ddType.not_in' => 'A valid type must be selected!',
            'ddModel.requried' => 'Status is required!',
        ];
    }
}
