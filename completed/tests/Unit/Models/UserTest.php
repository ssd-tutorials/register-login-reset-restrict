<?php

namespace AppTest\Unit\Models;

use App\Models\User;
use AppTest\BaseCase;
use AppTest\Traits\Database;

class UserTest extends BaseCase
{
    use Database;

    private $properties = [
        'active' => 0,
        'name' => 'Sebastian Sulinski',
        'email' => 'info@ssdtutorials.com',
        'password' => 'secret',
        'token' => null,
        'remember_token' => null
    ];

    /**
     * Create and return new User instance.
     *
     * @param array $items
     * @return User
     */
    public function makeUser(array $items = [])
    {
        return User::create($this->items($items));
    }

    /**
     * Merge properties.
     *
     * @param array $items
     * @return array
     */
    private function items(array $items = [])
    {
        if (empty($items)) {
            return $this->properties;
        }

        return array_merge($this->properties, $items);
    }

    /**
     * Verify user.
     *
     * @param User $user
     * @param array $items
     */
    private function verifyUser(User $user, array $items = [])
    {
        $items = $this->items($items);

        $this->assertInstanceOf(
            User::class,
            $user,
            "User::find did not return instance of User"
        );

        $this->assertEquals(
            $items['name'],
            $user->name,
            "User::create did not add record with the correct name"
        );

        $this->assertEquals(
            $items['email'],
            $user->email,
            "User::create did not add record with the correct email address"
        );

        $this->assertEquals(
            $items['token'],
            $user->token,
            "User::create did not add record with the correct token"
        );

        $this->assertEquals(
            $items['remember_token'],
            $user->remember_token,
            "User::create did not add record with the correct remember_token"
        );

        $this->assertTrue(
            $user->verifyPassword($items['password']),
            "User::create did not add record with the correct password"
        );
    }

    /**
     * @test
     */
    public function can_create_and_find_new_user_record()
    {
        $this->makeUser();

        $user = User::find(1);

        $this->verifyUser($user);
    }

    /**
     * @test
     */
    public function gets_user_by_email()
    {
        $this->makeUser();

        $user = User::byEmail($this->properties['email'])->first();

        $this->verifyUser($user);
    }

    /**
     * @test
     */
    public function gets_user_by_token_and_resets_token()
    {
        $this->makeUser(['token' => 'abc']);

        $user = User::byToken('abc')->first();

        $this->verifyUser($user, ['token' => 'abc']);

        $user->resetToken();

        $user = User::find($user->id);

        $this->assertNotEquals(
            'abc',
            $user->token,
            "User::setToken did not reset the token"
        );
    }

    /**
     * @test
     */
    public function gets_user_by_remember_token()
    {
        $this->makeUser(['remember_token' => 555]);

        $user = User::byRememberToken(555)->first();

        $this->verifyUser($user, ['remember_token' => 555]);
    }

    /**
     * @test
     */
    public function identifies_and_makes_user_active()
    {
        $user = $this->makeUser();

        $this->assertFalse(
            $user->isActive(),
            "User::isActive returned true with inactive user"
        );

        $user->makeActive();

        $user = User::find($user->id);

        $this->assertTrue(
            $user->isActive(),
            "User::isActive returned false with active user"
        );
    }

    /**
     * @test
     */
    public function updates_password()
    {
        $user = $this->makeUser();

        $user = User::find($user->id);

        $this->assertTrue(
            $user->verifyPassword('secret'),
            "User::create did not add record with the correct, hashed password"
        );

        $user->updatePassword('password');

        $user = User::find($user->id);

        $this->assertTrue(
            $user->verifyPassword('password'),
            "User::updatePassword did not update the password"
        );
    }

    /**
     * @test
     */
    public function updates_remember_token()
    {
        $user = $this->makeUser();

        $user = User::find($user->id);

        $this->assertNull(
            $user->remember_token,
            "User::create did not add record with the remember_token set to null"
        );

        $user->updateRememberToken();

        $user = User::find($user->id);

        $this->assertNotNull(
            $user->remember_token,
            "User::updateRememberToken did not update the remember_token"
        );
    }
}