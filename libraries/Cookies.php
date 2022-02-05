<?php

namespace libraries;

/**
 * Cookies class
 * TODO: Put current user on cookies over session
 *
 * PHP version 7.2
 *
 * @category Session
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.7-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */
class Cookies
{
    /**
     * sets a specific value to a specific key of the cookie
     *
     * @param mixed $key
     * @param mixed $value
     * @param bool  $append - For arrays / objects
     */
    public static function set($key, $value, $expired_seconds)
    {
        setcookie($key, $value, $expired_seconds);
    }

    /**
     * gets/returns the value of a specific key of the cookie
     *
     * @param  mixed $key Usually a string
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
    }
}
