<?php

namespace App\Utilities\Cookie;

class ArrayCookie implements Contract
{
    /**
     * @var array
     */
    private static $cookie = [];

    /**
     * Get all cookies.
     *
     * @return array
     */
    public function all()
    {
        return static::$cookie;
    }

    /**
     * Check if cookie has a given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset(static::$cookie[$key]);
    }

    /**
     * Set cookie.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        static::$cookie[$key] = $value;
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

        return static::$cookie[$key];
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset(static::$cookie[$key]);
    }
}