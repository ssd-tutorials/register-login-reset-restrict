<?php

namespace App\Utilities\Validator\Rules;

class Confirmed extends Rule
{
    /**
     * Validate input.
     *
     * @return bool
     */
    public function validate()
    {
        $confirmation = $this->key . '_confirmation';

        return (
            $this->input->has($confirmation) &&
            $this->input[$this->key] === $this->input[$confirmation]
        );
    }
}