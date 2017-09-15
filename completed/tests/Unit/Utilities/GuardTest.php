<?php

namespace AppTest\Unit\Utilities;

use App\Models\User;
use AppTest\BaseCase;
use AppTest\Traits\Database;
use App\Utilities\Session\SessionManager;

class GuardTest extends BaseCase
{
    use Database;

    protected function setUp()
    {
        parent::setUp();

        SessionManager::start();
    }

    /**
     * @test
     */
    public function is_authenticated_method_returns_false_without_authenticated_user()
    {
        $this->assertFalse(
            parent::$container->make('guard')->isAuthenticated(),
            "Guard::isAuthenticated returned true without user being authenticated"
        );
    }

    /**
     * @test
     */
    public function logs_user_in_and_is_authenticated_method_returns_true()
    {
        $user = User::create([
            'name' => 'Sebastian Sulinski',
            'email' => 'info@ssdtutorials.com',
            'password' => 'secret'
        ]);

        parent::$container->make('guard')->login($user);

        $this->assertTrue(
            parent::$container->make('guard')->isAuthenticated(),
            "Guard::isAuthenticated returned false with authenticated user"
        );
    }

    /**
     * @test
     */
    public function returns_user_instance_after_login()
    {
        $user = User::create([
            'name' => 'Sebastian Sulinski',
            'email' => 'info@ssdtutorials.com',
            'password' => 'secret'
        ]);

        parent::$container->make('guard')->login($user);

        $guard = parent::$container->make('guard')->user();

        $this->assertEquals(
            [
                $user->id,
                $user->name,
                $user->email,
                $user->password
            ],
            [
                $guard->id,
                $guard->name,
                $guard->email,
                $guard->password
            ],
            "Guard::user does not return correct User instance"
        );
    }

    /**
     * @test
     */
    public function logout_logs_user_out()
    {
        $user = User::create([
            'name' => 'Sebastian Sulinski',
            'email' => 'info@ssdtutorials.com',
            'password' => 'secret'
        ]);

        parent::$container->make('guard')->login($user);

        $this->assertTrue(
            parent::$container->make('guard')->isAuthenticated(),
            "Guard::login did not log user in"
        );

        parent::$container->make('guard')->logout();

        $this->assertFalse(
            parent::$container->make('guard')->isAuthenticated(),
            "Guard::logout did not log user out"
        );
    }
}



















