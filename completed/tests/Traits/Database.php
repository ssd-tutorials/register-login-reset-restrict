<?php

namespace AppTest\Traits;

use App\Migration\Migration;

trait Database
{
    /**
     * Migrate database before each test.
     *
     * @return void
     */
    public function migrateDatabase()
    {
        (new Migration)->up();
    }

    /**
     * Roll back migrations after each test.
     *
     * @return void
     */
    public function rollBackDatabase()
    {
        (new Migration)->down();
    }
}