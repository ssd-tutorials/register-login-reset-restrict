<?php

namespace App\Utilities\Cookie;

use SSD\DotEnv\DotEnv;

class CookieManager
{
    /**
     * Delegate call to a method
     * of the chosen cookie class.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $cookie = static::className();

        return call_user_func_array([new $cookie, $name], $arguments);
    }

    /**
     * Get qualifying class name.
     *
     * @return string
     */
    private static function className()
    {
        $driver = DotEnv::get('COOKIE_DRIVER', 'file');

        return __NAMESPACE__ . "\\" . ucfirst($driver) . "Cookie";
    }

}