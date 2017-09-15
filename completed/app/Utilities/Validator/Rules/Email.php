<?php

namespace App\Utilities\Validator\Rules;

class Email extends Rule
{
    /**
     * Validate input.
     *
     * @return bool
     */
    public function validate()
    {
        return filter_var(
            $this->input[$this->key],
            FILTER_VALIDATE_EMAIL
        );
    }
}