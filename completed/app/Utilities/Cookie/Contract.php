<?php

namespace App\Utilities\Cookie;

interface Contract
{
    /**
     * Get all cookies.
     *
     * @return array
     */
    public function all();

    /**
     * Check if cookie has a given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Set cookie.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Get cookie.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @return void
     */
    public function remove($key);
}

















