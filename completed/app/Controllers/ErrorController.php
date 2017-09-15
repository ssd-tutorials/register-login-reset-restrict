<?php

namespace App\Controllers;

use Illuminate\View\View;

class ErrorController extends Controller
{
    /**
     * Index controller.
     *
     * @param null $message
     * @return View
     */
    public function index($message = null)
    {
        http_response_code(404);

        return $this->view('pages.error')->with('message', $message);
    }
}