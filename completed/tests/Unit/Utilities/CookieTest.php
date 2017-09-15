<?php

namespace AppTest\Unit\Utilities;

use AppTest\BaseCase;
use App\Utilities\Cookie\CookieManager;

class CookieTest extends BaseCase
{
    /**
     * @test
     */
    public function can_set_and_get_cookie()
    {
        CookieManager::set('test', 123);

        $this->assertTrue(
            CookieManager::has('test'),
            "CookieManager::has returned false after calling CookieManager::set"
        );

        $this->assertEquals(
            123,
            CookieManager::get('test'),
            "CookieManager::get returned incorrect value after calling CookieManager::set"
        );
    }

    /**
     * @test
     */
    public function can_get_all_cookies()
    {
        CookieManager::set('test', 123);
        CookieManager::set('test2', 345);

        $this->assertEquals(
            [
                'test' => 123,
                'test2' => 345
            ],
            CookieManager::all(),
            "CookieManager::all returned incorrect value after calling CookieManager::set"
        );
    }

    /**
     * @test
     * @depends can_get_all_cookies
     */
    public function can_remove_cookie()
    {
        CookieManager::remove('test');

        $this->assertFalse(
            CookieManager::has('test'),
            "CookieManager::has returned true after calling CookieManager::remove"
        );

        $this->assertCount(
            1,
            CookieManager::all(),
            "CookieManager::all did not return 1 after calling CookieManager::remove"
        );

        CookieManager::remove('test2');

        $this->assertCount(
            0,
            CookieManager::all(),
            "CookieManager::all did not return 0 after calling CookieManager::remove the second time"
        );
    }
}


















