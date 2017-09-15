<?php

namespace App\Utilities\Mail;

use Exception;
use SSD\DotEnv\DotEnv;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SmtpMail extends Mail
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

            return $this->execute($this->message());

        } catch (Exception $e) {

            $this->exception = $e->getMessage();
            return 0;

        }
    }

    /**
     * Process message.
     *
     * @param Swift_Message $message
     * @return int
     */
    private function execute(Swift_Message $message)
    {
        $mailer = Swift_Mailer::newInstance($this->transport());

        return $mailer->send($message);
    }

    /**
     * Build message.
     *
     * @return Swift_Message
     */
    private function message()
    {
        $message = Swift_Message::newInstance();
        $message->setFrom($this->from)
                ->setTo($this->to)
                ->setSubject($this->subject)
                ->setBody($this->body, $this->html());

        return $message;
    }

    /**
     * Get transport instance.
     *
     * @return Swift_SmtpTransport
     */
    private function transport()
    {
        $transport = Swift_SmtpTransport::newInstance();
        $transport->setHost(DotEnv::get('MAIL_HOST'))
                  ->setPort(DotEnv::get('MAIL_PORT'))
                  ->setUsername(DotEnv::get('MAIL_USERNAME'))
                  ->setPassword(DotEnv::get('MAIL_PASSWORD'));

        if ( ! empty($encryption = DotEnv::get('MAIL_ENCRYPTION'))) {
            $transport->setEncryption($encryption);
        }

        return $transport;
    }
}