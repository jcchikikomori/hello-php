<?php

namespace libraries;

/**
 * Cookies class
 * TODO: Put current user on cookies over session
 *
 * PHP version 7.2
 *
 * @category Cookies
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
     * @param mixed $key Cookie Key - Usually a string
     * @param mixed $value Cookie Value
     * @param bool  $expired_seconds - Cookie Expiry
     * @return void
     */
    public static function set($key, $value, $expired_seconds)
    {
        setcookie($key, $value, $expired_seconds);
        // If value was null/empty, unset the cookie as well
        if ($value == null) {
            unset($_COOKIE[$key]);
        }
    }

    /**
     * Gets/Returns the value of a specific key of the cookie
     *
     * @param  mixed $key Cookie Key - Usually a string
     * @return mixed either exists or not
     */
    public static function get($key): mixed
    {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return null;
    }
}
