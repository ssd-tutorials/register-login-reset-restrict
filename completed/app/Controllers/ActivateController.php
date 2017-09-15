<?php

namespace App\Controllers;

use Exception;
use App\Models\User;
use Illuminate\View\View;

class ActivateController extends Controller
{
    /**
     * Display activation page.
     *
     * @return View
     */
    public function index()
    {
        $this->activate();

        return $this->view('pages.activate');
    }

    /**
     * Activate user.
     *
     * @return void
     * @throws Exception
     */
    private function activate()
    {
        if (is_null($user = $this->getUserByToken())) {
            throw new Exception("Invalid request");
        }

        $user->makeActive();
    }
}