<?php

namespace App\Utilities\Validator\Rules;

class Required extends Rule
{
    /**
     * Validate input.
     *
     * @return bool
     */
    public function validate()
    {
        return ! empty($this->input[$this->key]);
    }
}