<?php

namespace AppTest;

use App\Utilities\Guard;
use App\Utilities\Kernel;
use AppTest\Traits\Database;
use App\Utilities\Mail\MailManager;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;


class BaseCase extends TestCase
{
    /**
     * @var Container
     */
    protected static $container;

    /**
     * This method is called before the first test
     * of the test class is run.
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        if ( ! static::$container) {

            static::$container = new Container;
            static::$container->instance('request', Request::capture());
            static::$container->instance('guard', new Guard);
            static::$container->bind('mail', function() {
                return MailManager::make();
            });

            (new Kernel(static::$container));

        }
    }

    /**
     * Set up environment before each test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        if (class_uses($this, Database::class)) {
            $this->migrateDatabase();
        }
    }

    /**
     * Tear down environment after each test.
     *
     * @return void
     */
    protected function tearDown()
    {
        parent::tearDown();

        if (class_uses($this, Database::class)) {
            $this->rollBackDatabase();
        }
    }
}