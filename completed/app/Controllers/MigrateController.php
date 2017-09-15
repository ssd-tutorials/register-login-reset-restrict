<?php

namespace App\Controllers;

use App\Migration\Migration;

class MigrateController extends Controller
{
    /**
     * Run migrations.
     *
     * @return void
     */
    public function index()
    {
        (new Migration)->up();
    }

    /**
     * Roll back migrations.
     *
     * @return void
     */
    public function down()
    {
        (new Migration)->down();
    }
}