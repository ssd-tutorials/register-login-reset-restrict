<?php

namespace App\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Show page.
     *
     * @return View
     */
    public function index()
    {
        $slug = $this->request->segment(1);

        return $this->view('pages.page')
                    ->with('slug', $slug);
    }
}