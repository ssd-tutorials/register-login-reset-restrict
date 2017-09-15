<?php

namespace App\Utilities\Mail;

use Exception;

class TestMail extends Mail
{
    /**
     * Send message.
     *
     * @return int
     */
    public function send()
    {
        try {

            $this->validate();

            return count($this->to);

        } catch (Exception $e) {

            $this->exception = $e->getMessage();
            return 0;

        }
    }
}