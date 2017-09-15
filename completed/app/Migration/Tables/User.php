<?php

namespace App\Migration\Tables;

use App\Migration\TableContract;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;

class User implements TableContract
{
    /**
     * Run migration.
     *
     * @return void
     */
    public function up()
    {
        Manager::schema()->create('users', function(Blueprint $table) {

            $table->increments('id');
            $table->tinyInteger('active')->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Roll back migration.
     *
     * @return void
     */
    public function down()
    {
        Manager::schema()->dropIfExists('users');
    }
}