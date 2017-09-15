<?php

namespace App\Utilities\Cookie;

class FileCookie implements Contract
{
    /**
     * Get all cookies.
     *
     * @return array
     */
    public function all()
    {
        return $_COOKIE;
    }

    /**
     * Check if cookie has a given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Set cookie.
     *
     * @param string $key
     * @param mixed $value
     * @param int $duration
     * @return void
     */
    public function set($key, $value, $duration = 0)
    {
        setcookie($key, $value, $duration, '/');
    }

    /**
     * Get cookie.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if ( ! $this->has($key)) {
            return null;
        }

        return $_COOKIE[$key];
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        setcookie($key, '', time() - 1000, '/');
    }
}