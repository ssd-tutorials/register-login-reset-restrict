<?php

namespace App\Utilities\Session;

class ArraySession implements Contract
{
    /**
     * @var array
     */
    private static $session = [];

    /**
     * Start session.
     *
     * @return void
     */
    public function start()
    {
        static::$session = [];
    }

    /**
     * Get all sessions.
     *
     * @return array
     */
    public function all()
    {
        return static::$session;
    }

    /**
     * Check if session has a given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, static::$session);
    }

    /**
     * Set session.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        static::$session[$key] = $value;
    }

    /**
     * Get session.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        if ( ! $this->has($key)) {
            return null;
        }

        return static::$session[$key];
    }

    /**
     * Remove session by key.
     *
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        unset(static::$session[$key]);
    }

    /**
     * Destroy session.
     *
     * @return void
     */
    public function destroy()
    {
        static::$session = [];
    }
}