<?php

namespace App\Rules;

use App\Models\Device;
use Illuminate\Contracts\Validation\Rule;


class InventoryIdsExists implements Rule
{
    private $wrongIds = [];
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct($value)
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $allValid = true;
        foreach ($value as $id) {
            if (!Device::where('inventory_id', $id)->exists()) {
                $this->wrongIds[] = $id;
                $allValid = false;
            }
        }

        return $allValid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (count($this->wrongIds) == 1) {
            return 'The Inventory ID: ' . $this->wrongIds[0] . ' was not found.';
        } else {
            return "The following Inventory ID's were not found: " . implode(', ', $this->wrongIds);
        }
    }
}
