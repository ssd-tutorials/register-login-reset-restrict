<?php

namespace App\Utilities;

use SSD\Blade\Blade;
use SSD\DotEnv\DotEnv;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

class Kernel
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Kernel constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        Container::setInstance($this->container);

        $this->database();
    }

    /**
     * Configure the database and boot Eloquent.
     *
     * @return void
     */
    private function database()
    {
        $capsule = new Capsule($this->container);
        $capsule->addConnection([
            'driver' => DotEnv::get('DB_CONNECTION'),
            'host' => DotEnv::get('DB_HOST'),
            'database' => DotEnv::get('DB_DATABASE'),
            'username' => DotEnv::get('DB_USERNAME'),
            'password' => DotEnv::get('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => ''
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        date_default_timezone_set('UTC');
    }

    /**
     * Get instance of App.
     *
     * @param string $bladeViews
     * @param string $bladeCache
     * @return App
     */
    public function make($bladeViews, $bladeCache)
    {
        return new App(
            $this->container,
            new Blade(
                $bladeViews,
                $bladeCache,
                $this->container
            )
        );
    }
}