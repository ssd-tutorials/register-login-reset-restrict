<?php

namespace App\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display dashboard page.
     *
     * @return View
     */
    public function index()
    {
        $this->authorise();

        return $this->view('pages.dashboard')->with('user', $this->guard->user());
    }
}