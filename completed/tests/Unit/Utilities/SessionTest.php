<?php

namespace AppTest\Unit\Utilities;

use AppTest\BaseCase;
use App\Utilities\Session\SessionManager;

class SessionTest extends BaseCase
{
    /**
     * @test
     */
    public function can_set_and_get_session()
    {
        SessionManager::start();

        SessionManager::set('test', 123);

        $this->assertTrue(
            SessionManager::has('test'),
            "Session::has returned false after calling Session::set"
        );

        $this->assertEquals(
            123,
            SessionManager::get('test'),
            "Session::get returned incorrect value after calling Session::set"
        );
    }

    /**
     * @test
     * @depends can_set_and_get_session
     */
    public function can_remove_session()
    {
        SessionManager::remove('test');

        $this->assertFalse(
            SessionManager::has('test'),
            "Session::has returned false after calling Session::remove"
        );

        $this->assertCount(
            0,
            SessionManager::all(),
            "Session::all did not return 0 records after calling Session::remove"
        );
    }

    /**
     * @test
     */
    public function can_destroy_session()
    {
        SessionManager::start();

        SessionManager::set('test', [123, 'abc']);

        $this->assertTrue(
            SessionManager::has('test'),
            "Session::has returned false after calling Session::set with array"
        );

        $this->assertEquals(
            [123, 'abc'],
            SessionManager::get('test'),
            "Session::get returned incorrect value after calling Session::set with array"
        );

        SessionManager::destroy();

        $this->assertCount(
            0,
            SessionManager::all(),
            "Session::all did not return 0 records after calling Session::destroy"
        );
    }
}










