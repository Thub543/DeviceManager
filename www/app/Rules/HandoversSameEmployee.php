<?php

namespace App\Rules;

use App\Models\Handover;
use Illuminate\Contracts\Validation\Rule;

class HandoversSameEmployee implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value = selected handovers ids
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $handovers = Handover::whereIn('id',$value)->get();
        $employee_id = $handovers[0]->employee_id;
        foreach($handovers as $handover){
            if($handover->employee_id != $employee_id){
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Handovers are not from the same employee.';
    }
}
