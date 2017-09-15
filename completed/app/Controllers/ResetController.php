<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ResetController extends Controller
{
    /**
     * @var array
     */
    protected $rules = [
        'password' => 'required|confirmed',
        'password_confirmation' => 'required'
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
     * Display reset password form.
     *
     * @return View
     * @throws Exception
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->view('pages.reset')->with('user', $user);
    }

    /**
     * Get user instance.
     *
     * @return User
     * @throws Exception
     */
    private function getUser()
    {
        if (is_null($user = $this->getUserByToken())) {

            $this->addError('password', 'token');
            throw new Exception("Invalid request");

        }

        return $user;
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

            $user = $this->getUser();

            $this->collectRequest([
                'password',
                'password_confirmation'
            ]);

            $this->validateRequest();

            $this->input->offsetUnset('password_confirmation');

            $this->updatePassword($user);

            $message  = 'Your password has been updated successfully<br />';
            $message .= 'You can now <a href="/">log in</a>';

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
     * Update user password.
     *
     * @param User $user
     * @throws Exception
     */
    private function updatePassword(User $user)
    {
        if ( ! $user->updatePassword($this->input->get('password'))) {

            $this->addError('password', 'failed');
            throw new Exception("Password could not be updated");

        }
    }
}














