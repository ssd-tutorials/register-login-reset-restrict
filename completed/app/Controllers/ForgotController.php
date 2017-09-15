<?php

namespace App\Controllers;

use App\Models\User;

use App\Notifications\ResetPasswordEmail;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use SSD\DotEnv\DotEnv;
use Symfony\Component\HttpFoundation\Response;

class ForgotController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'email' => 'required|email'
    ];

    /**
     * Add to parent constructor.
     *
     * @return void
     */
    protected function constructor()
    {
        $this->redirectIfLoggedIn();
    }

    /**
     * Display forgot password form.
     *
     * @return View
     */
    public function index()
    {
        return $this->view('pages.forgot');
    }

    public function post()
    {
        $this->postRequestOnly();

        try {

            $this->collectRequest([
                'email'
            ]);

            $this->validateRequest();

            $user = $this->validateEmail();

            if ( ! $this->sendEmail($user)) {

                $this->addError('email', 'technical');
                throw new Exception("Sending email failed");

            }

            return (new JsonResponse([
                'message' => 'Please check your mailbox for instructions on how to reset your password.'
            ]))->sendHeaders()->getContent();

        } catch (Exception $e) {

            return (new JsonResponse(
                $this->errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            ))->sendHeaders()->getContent();

        }
    }

    /**
     * Validate email address.
     *
     * @return User
     * @throws Exception
     */
    private function validateEmail()
    {
        if (is_null($user = User::byEmail($this->input['email'])->first())) {

            $this->addError('email', 'invalid');
            throw new Exception("Email does not exist");

        }

        return $user;
    }

    /**
     * Send email with instructions
     * on how to reset your password.
     *
     * @param User $user
     * @return int
     */
    private function sendEmail(User $user)
    {
        return $this->dispatch(new ResetPasswordEmail(
            $user,
            $this->container->make('mail'),
            $this->container->make('request')
        ));
    }
}