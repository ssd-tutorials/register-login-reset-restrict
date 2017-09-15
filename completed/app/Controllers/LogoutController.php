<?php

namespace App\Controllers;

use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends Controller
{
    /**
     * Log user out and redirect to the login page.
     *
     * @return Response
     */
    public function index()
    {
        $this->guard->logout();

        return (new RedirectResponse('/'))->send();
    }
}