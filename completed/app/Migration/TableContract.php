<?php

namespace App\Migration;

interface TableContract
{
    /**
     * Run migration.
     *
     * @return void
     */
    public function up();

    /**
     * Roll back migration.
     *
     * @return void
     */
    public function down();
}