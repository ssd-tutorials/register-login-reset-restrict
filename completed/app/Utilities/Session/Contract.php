<?php

namespace App\Utilities\Session;

interface Contract
{
    /**
     * Start session.
     *
     * @return void
     */
    public function start();

    /**
     * Get all sessions.
     *
     * @return array
     */
    public function all();

    /**
     * Check if session has a given key.
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Set session.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Get session.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key);

    /**
     * Remove session by key.
     *
     * @param mixed $key
     * @return void
     */
    public function remove($key);

    /**
     * Destroy session.
     *
     * @return void
     */
    public function destroy();

}


















