<?php

namespace App\Utilities\Session;

use SSD\DotEnv\DotEnv;

class SessionManager
{
    /**
     * Delegate call to a method
     * of the chosen session class.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $session = static::className();

        return call_user_func_array([new $session, $name], $arguments);
    }

    /**
     * Get qualifying session driver class name.
     *
     * @return string
     */
    private static function className()
    {
        $driver = DotEnv::get('SESSION_DRIVER', 'file');

        return __NAMESPACE__ . "\\" . ucfirst($driver) . "Session";
    }

}