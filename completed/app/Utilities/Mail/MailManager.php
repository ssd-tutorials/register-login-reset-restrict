<?php

namespace App\Utilities\Mail;

use SSD\DotEnv\DotEnv;

class MailManager
{
    /**
     * Get instance of the mail class.
     *
     * @param array $params
     * @return Mail
     */
    public static function make(array $params = [])
    {
        $className = static::className();

        return new $className($params);
    }

    /**
     * Get qualifying class name.
     *
     * @return string
     */
    private static function className()
    {
        $driver = DotEnv::get('MAIL_DRIVER', 'smtp');

        return __NAMESPACE__ . "\\" . ucfirst($driver) . "Mail";
    }
}