<?php

namespace App\Utilities\Mail;

use App\Traits\Binder;

use Exception;
use Illuminate\Support\Collection;

abstract class Mail
{
    use Binder;

    /**
     * @var array
     */
    protected $from = [];

    /**
     * @var array
     */
    protected $to = [];

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var bool
     */
    protected $html = true;

    /**
     * @var string
     */
    public $exception;

    /**
     * Mail constructor.
     *
     * @param array $props
     */
    public function __construct(array $props = [])
    {
        $this->bind(new Collection($props));
    }

    /**
     * Associate email property type.
     *
     * @param string|array $emails
     * @param null|string $name
     * @param array $property
     */
    private function emailName($emails, $name = null, &$property)
    {
        if (is_array($emails)) {
            $this->emailNameArray($emails, $property);
            return;
        }

        $name = ! is_null($name) ? $name : $emails;

        $property[$emails] = $name;
    }

    /**
     * Associate array of email property types.
     *
     * @param array $emails
     * @param array $property
     */
    private function emailNameArray(array $emails, &$property)
    {
        foreach($emails as $email => $name) {

            if ( ! is_string($email)) {
                $email = $name;
            }

            $property[$email] = $name;
        }
    }

    /**
     * Add from option.
     *
     * @param string|array $emails
     * @param null|string $name
     * @return $this
     */
    public function addFrom($emails, $name = null)
    {
        $this->emailName($emails, $name, $this->from);

        return $this;
    }

    /**
     * Get from option.
     *
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Add to option.
     *
     * @param string|array $emails
     * @param null|string $name
     * @return $this
     */
    public function addTo($emails, $name = null)
    {
        $this->emailName($emails, $name, $this->to);

        return $this;
    }

    /**
     * Get to option.
     *
     * @return array
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set subject of the message.
     *
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject of the message.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body of the message.
     *
     * @param string $body
     * @param bool $html
     * @return $this
     */
    public function setBody($body, $html = true)
    {
        $this->body = $body;
        $this->html = $html;

        return $this;
    }

    /**
     * Get body of the message.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get content type.
     *
     * @return null|string
     */
    protected function html()
    {
        return $this->html ? 'text/html' : null;
    }

    /**
     * Reset all properties of the object.
     *
     * @return void
     */
    public function reset()
    {
        $this->from = [];
        $this->to = [];
        $this->subject = null;
        $this->body = null;
        $this->html = true;
    }

    /**
     * Check if message is valid.
     *
     * @return void
     * @throws Exception
     */
    protected function validate()
    {
        if ( ! $this->check()) {
            throw new Exception("Message is incomplete");
        }
    }

    /**
     * Check if message is ready to be send.
     *
     * @return bool
     */
    private function check()
    {
        return (
            ! empty($this->from) &&
            ! empty($this->to) &&
            ! empty($this->subject) &&
            ! empty($this->body)
        );
    }

    /**
     * Send message.
     *
     * @return int
     */
    abstract public function send();
}