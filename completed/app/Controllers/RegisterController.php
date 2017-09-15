<?php

namespace App\Controllers;

use App\Models\User;

use App\Notifications\ActivationEmail;
use Exception;
use SSD\DotEnv\DotEnv;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required'
    ];

    /**
     * Add to parent constructor.
     *
     * @return null|Response
     */
    protected function constructor()
    {
        return $this->redirectIfLoggedIn();
    }

    /**
     * Display registration form.
     *
     * @return View
     */
    public function index()
    {
        return $this->view('pages.register');
    }

    /**
     * Process request.
     *
     * @return string
     */
    public function post()
    {
        $this->postRequestOnly();

        try {

            $this->collectRequest([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $this->validateRequest();

            $this->validateEmail();

            $this->input->offsetUnset('password_confirmation');

            return $this->addUser();

        } catch(Exception $e) {

            return (new JsonResponse(
                $this->errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            ))->sendHeaders()->getContent();

        }
    }

    /**
     * Check if email address is already taken.
     *
     * @return void
     * @throws Exception
     */
    private function validateEmail()
    {
        $user = User::byEmail($this->input->get('email'))->first();

        if ( ! is_null($user)) {

            $this->addError('email', 'taken');
            throw new Exception("Email address already in use");

        }
    }

    /**
     * Add new user.
     *
     * @return string
     * @throws Exception
     */
    private function addUser()
    {
        if ( ! $user = User::create($this->input->toArray())) {

            $this->addError('name', 'failed');
            throw new Exception("Could not add new user record");

        }

        if (DotEnv::is('VERIFICATION', true)) {
            return $this->activation($user);
        }

        $this->guard->login($user);

        return (new JsonResponse([
            'redirect' => '/dashboard'
        ]))->sendHeaders()->getContent();
    }

    /**
     * Process activation email.
     *
     * @param User|null $user
     * @return string
     */
    public function activation(User $user = null)
    {
        try {

            if (is_null($user)) {
                $user = User::byEmail($this->request->get('email'))->first();
            }

            if (is_null($user)) {

                $this->addError('email', 'invalid');
                throw new Exception("Invalid email address");

            }

            if ( ! $this->sendActivationEmail($user)) {

                $this->addError('email', 'technical');
                throw new Exception("Email could not be sent");

            }

            $message = 'Please check your email for instructions on how to activate your account.';

            return (new JsonResponse([
                'message' => $message
            ]))->sendHeaders()->getContent();

        } catch (Exception $e) {

            return (new JsonResponse(
                $this->errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            ))->sendHeaders()->getContent();

        }
    }

    /**
     * Send activation email.
     *
     * @param User $user
     * @return int
     */
    private function sendActivationEmail(User $user)
    {
        return $this->dispatch(new ActivationEmail(
            $user,
            $this->container->make('mail'),
            $this->container->make('request')
        ));
    }
}