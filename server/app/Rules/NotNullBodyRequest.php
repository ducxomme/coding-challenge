<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class NotNull
 * @package App\Rules
 */
final class NotNullBodyRequest implements Rule
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
        return !is_null($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Body リクエストの形式が不正です。';
    }
}
