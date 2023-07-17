<?php

namespace App\Http\Requests\HandoverRequests;

use App\Rules\DeviceIsAvailable;
use App\Rules\InventoryIdsExists;
use Illuminate\Foundation\Http\FormRequest;


class HandoverOnboardRequest extends FormRequest
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


    protected function prepareForValidation(): void
    {
        $this->merge([
            'devices' => array_filter($this->devices),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'employeeId' => 'required|exists:employees,id',
            'devices' => ['required','array', 'min:1',
                new InventoryIdsExists($this->devices),
                new DeviceIsAvailable($this->devices)],
            'devices.*' => 'distinct',
        ];
    }

    public function messages()
    {
        return [
            'employeeId.required' => 'Select an Employee',
            'devices.*.distinct' => 'The same device is entered twice',
        ];
    }
}
