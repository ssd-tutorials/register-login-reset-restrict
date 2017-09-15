<?php

namespace App\Notifications;

use App\Models\User;
use App\Utilities\Mail\Mail;
use App\Utilities\Event\Job;

use SSD\DotEnv\DotEnv;
use Illuminate\Http\Request;

class ResetPasswordEmail implements Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Mail
     */
    private $mail;

    /**
     * @var Request
     */
    private $request;

    /**
     * ActivationEmail constructor.
     * @param User $user
     * @param Mail $mail
     * @param Request $request
     */
    public function __construct(User $user, Mail $mail, Request $request)
    {
        $this->user = $user;
        $this->mail = $mail;
        $this->request = $request;
    }

    /**
     * Handle the job.
     *
     * @return int
     */
    public function handle()
    {
        return $this->mail->addFrom(
                DotEnv::get('BUSINESS_EMAIL'),
                DotEnv::get('BUSINESS_NAME')
            )
            ->addTo($this->user->email, $this->user->name)
            ->setSubject('Password reset request')
            ->setBody($this->messageBody())
            ->send();
    }

    /**
     * Get message body.
     *
     * @return string
     */
    private function messageBody()
    {
        $url = $this->request->root() . '/reset?token=' . $this->user->resetToken();

        $out  = '<p>Please click the link below in order to reset your password.</p>';
        $out .= '<a href="';
        $out .= $url;
        $out .= '" target="_blank">';
        $out .= $url;
        $out .= '</a>';

        return $out;
    }
}