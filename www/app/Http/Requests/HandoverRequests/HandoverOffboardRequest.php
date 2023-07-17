<?php

namespace App\Http\Requests\HandoverRequests;

use Illuminate\Foundation\Http\FormRequest;

class HandoverOffboardRequest extends FormRequest
{

    //redirect to offboarding page without error message
    protected $redirectRoute = "activeHandovers";
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
            'ddStatus' => 'exists:statuses,id',
            'handoversid' => 'exists:handovers,id',
        ];
    }

    public function messages()
    {
        return [
            'ddStatus.exists' => 'This is not a valid Statusid!',
            'handoversid.exists' => 'This is not a valid Statusid!',
        ];
    }


}
