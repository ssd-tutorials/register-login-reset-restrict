<?php

namespace App\Migration;

use App\Migration\Tables\User;

class Migration
{
    /**
     * Run migrations.
     *
     * @return void
     */
    public function up()
    {
        (new User)->up();
    }

    /**
     * Roll back migrations.
     *
     * @return void
     */
    public function down()
    {
        (new User)->down();
    }
}