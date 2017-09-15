<?php

namespace App\Utilities;

use App\Models\User;
use App\Utilities\Cookie\CookieManager;
use App\Utilities\Session\SessionManager;
use Carbon\Carbon;

class Guard
{
    /**
     * @var string
     */
    const SESSION_NAME = 'auth';

    /**
     * @var string
     */
    const REMEMBER_ME = 'remember_me';

    /**
     * @var User
     */
    public $authenticated;

    /**
     * Check if user is logged in.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        $session = SessionManager::get(self::SESSION_NAME);

        if (empty($session)) {
            return $this->isRemembered();
        }

        return Hash::verify(
            $session['id'],
            $session['hash']
        );
    }

    /**
     * Check if user has a cookie set
     * to keep him/her logged in.
     *
     * @return bool
     */
    private function isRemembered()
    {
        if ( ! $token = $this->rememberToken()) {
            return false;
        }

        $this->authenticated = User::byRememberToken($token)->first();

        if (is_null($this->authenticated)) {
            return false;
        }

        $this->login($this->authenticated);

        return true;
    }

    /**
     * Get remember me token.
     *
     * @return string|null
     */
    private function rememberToken()
    {
        return CookieManager::get(self::REMEMBER_ME);
    }

    /**
     * Remove remember me token.
     *
     * @return void
     */
    private function forgetToken()
    {
        CookieManager::remove(self::REMEMBER_ME);
    }

    /**
     * Log user in.
     *
     * @param User $user
     * @param bool $remember
     */
    public function login(User $user, $remember = false)
    {
        SessionManager::set(
            self::SESSION_NAME,
            [
                'id' => $user->id,
                'hash' => Hash::make($user->id)
            ]
        );

        if ($remember) {
            static::setRemember($user);
        }
    }

    /**
     * Set remember token.
     *
     * @param User $user
     */
    private static function setRemember(User $user)
    {
        $user->updateRememberToken();

        CookieManager::set(
            self::REMEMBER_ME,
            $user->remember_token,
            Carbon::now()->addYear()->timestamp
        );
    }

    /**
     * Log out user.
     *
     * @return void
     */
    public function logout()
    {
        SessionManager::remove(self::SESSION_NAME);
        $this->forgetToken();
    }

    /**
     * Get instance of the authenticated user.
     *
     * @return null|User
     */
    public function user()
    {
        if ( ! $this->isAuthenticated()) {
            return null;
        }

        return $this->getUser();
    }

    /**
     * Get user instance by session
     * or remember me token.
     *
     * @return User
     */
    private function getUser()
    {
        if (SessionManager::has(self::SESSION_NAME)) {
            return User::find(
                SessionManager::get(self::SESSION_NAME)['id']
            );
        }

        return $this->authenticated;
    }
}