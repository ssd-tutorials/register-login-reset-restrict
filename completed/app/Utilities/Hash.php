<?php

namespace App\Utilities;

class Hash
{
    /**
     * Hash string.
     *
     * @param string $string
     * @return string
     */
    public static function make($string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    /**
     * Verify string against the hash.
     *
     * @param string $string
     * @param string $hash
     * @return bool
     */
    public static function verify($string, $hash)
    {
        return password_verify($string, $hash);
    }
}