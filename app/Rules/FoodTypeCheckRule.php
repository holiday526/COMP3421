<?php

namespace App\Rules;

use App\FoodType;
use Illuminate\Contracts\Validation\Rule;

class FoodTypeCheckRule implements Rule
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
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        return in_array($value, FoodType::pluck('name')->toArray());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Food type not found';
    }
}
