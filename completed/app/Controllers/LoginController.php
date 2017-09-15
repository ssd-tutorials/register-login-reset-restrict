<?php

namespace App\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use SSD\DotEnv\DotEnv;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;

class LoginController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required'
    ];

    /**
     * Redirect if user is logged in.
     *
     * @return null|Response
     */
    protected function constructor()
    {
        return $this->redirectIfLoggedIn();
    }

    /**
     * Display login form.
     *
     * @return View
     */
    public function index()
    {
        return $this->view('pages.login');
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
                'email', 'password', 'remember_me'
            ]);

            $this->validateRequest();

            $this->guard->login(
                $this->verifyUser(),
                $this->input->get('remember_me')
            );

            return (new JsonResponse([
                'redirect' => '/dashboard'
            ]))->sendHeaders()->getContent();

        } catch (Exception $e) {

            return (new JsonResponse(
                $this->errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            ))->sendHeaders()->getContent();

        }
    }

    /**
     * Verify user.
     *
     * @return User
     * @throws Exception
     */
    private function verifyUser()
    {
        $user = User::byEmail($this->input->get('email'))->first();

        if ( ! is_null($user)) {
            return $this->checkUserPassword($user);
        }

        return $this->invalidCredentials();
    }

    /**
     * Check password.
     *
     * @param User $user
     * @return User
     * @throws Exception
     */
    private function checkUserPassword(User $user)
    {
        if ( ! $user->verifyPassword($this->input->get('password'))) {
            return $this->invalidCredentials();
        }

        return $this->checkIfActive($user);
    }

    /**
     * Invalid credentials exception.
     *
     * @throws Exception
     */
    private function invalidCredentials()
    {
        $this->addError('email', 'invalid');
        throw new Exception("User not found");
    }

    /**
     * Check if user is active.
     *
     * @param User $user
     * @return User
     * @throws Exception
     */
    private function checkIfActive(User $user)
    {
        if (DotEnv::is('VERIFICATION', true) && ! $user->isActive()) {
            return $this->inactive();
        }

        return $user;
    }

    /**
     * Inactive exception.
     *
     * @throws Exception
     */
    private function inactive()
    {
        $this->addError('email', 'inactive');
        throw new Exception("User not active");
    }
}