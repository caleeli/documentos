<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UntilToday implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value->format('Y-m-d') <= date('Y-m-d');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.until_today');
    }
}
