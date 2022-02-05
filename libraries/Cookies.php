<?php

namespace libraries;

/**
 * Session class
 *
 * handles the session stuff. creates session when no one exists, sets and
 * gets values, and closes the session properly (=logout). Those methods
 * are STATIC, which means you can call them with Session::get(XXX);
 * New tests (as of 04-16-2017): Multi-user setups like the Google Auth System
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
     * sets a specific value to a specific key of the session
     *
     * @param mixed $key
     * @param mixed $value
     * @param bool  $append - For arrays / objects
     */
    public static function set($key, $value, $append = false)
    {
        if (is_array($value) && $append) {
            $arr = $_SESSION[$key]; // expecting as array/object
            array_merge($arr, $value);
            $_SESSION[$key] = $arr;
        } else {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Alternate version of set() for users
     * sets a specific value to a specific key of the session
     * NOTES:
     * - "self" is a static version of $this
     * WARNING: This will overwrite/add the value to the
     * current user unless $id specified!
     *
     * @param mixed $key
     * @param mixed $value
     * @param $id
     */
    public static function set_user($key, $value, $id = null)
    {
        if (empty($id)) {
            $id = self::get('current_user');
        }
        $_SESSION['users'][$id][$key] = $value;
    }

    /**
     * gets/returns the value of a specific key of the session
     *
     * @param  mixed $key Usually a string
     * @return mixed
     */
    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            // Debugger::dump($key);
            return $_SESSION[$key];
        }
    }
}
