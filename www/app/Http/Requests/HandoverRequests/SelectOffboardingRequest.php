<?php

namespace App\Http\Requests\HandoverRequests;

use App\Rules\HandoversSameEmployee;
use Illuminate\Foundation\Http\FormRequest;

class SelectOffboardingRequest extends FormRequest
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
            'selectedHandovers' => ['required','array','exists:handovers,id',
                new HandoversSameEmployee($this->selectedHandovers),'min:1', 'max:10'],
        ];
    }

    public function messages()
    {
        return [
            'selectedHandovers.required' => 'No handovers selected',
            'selectedHandovers.min' => 'At least 1 handover must be selected',
            'selectedHandovers.max' => 'Only 10 handovers can be selected at once',
        ];
    }
}
