<?php

namespace App\Http\Requests\LocationRequests;

use Illuminate\Foundation\Http\FormRequest;

class LocationAddEditRequest extends FormRequest
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
            'location_initials' => strtoupper($this->location_initials),
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
            'location_name' => 'required|max:50',
            'location_initials' => 'required|min:2|max:4|unique:locations,location_initials,'.$this->route('location')
        ];
    }

    public function messages()
    {
        return [
            'location_name.required' => 'Location name is required',
            'location_name.max' => 'Max 50chars at Location name',
            'location_initials.required' => 'Initials are required',
            'location_initials.max' => 'Max 4 chars at initials',
            'location_initials.min' => 'Min 2 chars at initials',
        ];
    }
}
