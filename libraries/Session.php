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
 * @package  PHP7Starter
 * @author   Chris (panique) <panique@noemail.com>
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class Session
{
    /**
     * starts the session
     */
    public static function init()
    {
        // if no session exist, start the session
        if (session_id() == '') {
            session_start();
        }
    }

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

    /**
     * gets/returns the value of a specific user currently log in
     *
     * @param  $key - User Details
     * @return mixed
     */
    public static function get_user_details($key)
    {
        if (isset($_SESSION['users']) && self::user_logged_in()) {
            $id = $_SESSION['current_user'];
            if (isset($_SESSION['users'][$id][$key])) {
                return $_SESSION['users'][$id][$key];
            }
        }
    }

    /**
     * gets/returns the value of a specific user currently log in
     *
     * @param  $key - User Details
     * @param  null $uid
     * @return mixed
     */
    public static function get_user($key, $uid)
    {
        if (isset($_SESSION['users'][$uid])) {
            $id = $uid;
            if (isset($_SESSION['users'][$id][$key])) {
                return $_SESSION['users'][$id][$key];
            }
        }
    }

    /**
     * TODO: Simple operations for a while
     *
     * @return bool
     */
    public static function user_logged_in()
    {
        // $_GET["logout"] must not be set, unless the app will log you out
        if (isset($_GET["logout"])) {
            return false;
        }
        return isset($_SESSION['current_user']) && !empty($_SESSION['current_user']);
    }

    /**
     * deletes each sessions
     *
     * @param $key
     */
    public static function destroy($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * logging out specific user
     *
     * @param  null $user user id
     * @param  $key  - specified key
     * @return bool
     */
    public static function destroy_user($user = null, $key = null)
    {

        // If specified user was none
        if (empty($user)) {
            $user_id = (isset($_SESSION['current_user'])) ? $_SESSION['current_user'] : null;
        } else {
            $user_id = $user;
        }

        /**
         * If specified user_id in current session still
         * does exists, it will destroy key with
         * corresponding user_id
         */
        if (!empty($user_id)) {
            unset($_SESSION['users'][$user_id]);
            if (!empty($key)) {
                unset($_SESSION['users'][$user_id][$key]);
            }
            $_SESSION['current_user'] = null;
            return true;
        } else {
            return false;
        }
    }

    /**
     * deletes each sessions
     */
    public static function destroy_all()
    {
        session_destroy();
    }

    /**
     * Get multi user status by session
     * by counting current users in session
     *
     * @return mixed
     */
    public static function multi_user_status()
    {
        if (count(self::get('users')) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if the user is still in session
     *
     * @param  $id
     * @return bool
     */
    public static function check_user($id)
    {
        $users = self::get('users');
        foreach ($users as $user => $value) {
            if ($user == $id) {
                return true;
            }
        }
        return false;
    }
}
