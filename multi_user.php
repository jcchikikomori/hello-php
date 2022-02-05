<?php

/**
 * Multi-user index
 * This is only works with multi-user switch on
 *
 * PHP version 7.2
 *
 * @category Auth
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  GIT: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */

// Core components first such as main classes then load dependencies
// then Instantiate the class to use it
require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/concerns/RememberMe.php";

// load the auth class then instantiate again
$auth = new classes\Auth();

if (
    ($auth->isUserLoggedIn() && $auth->multi_user_requested)
    // either multi-user login or switch user (requires multi-user too)
    || (!$auth->isUserLoggedIn() && $auth->switch_user_requested)
) {
    // then render
    $data['multi_user_requested'] = $auth->multi_user_requested;
    $data['switch_user_requested'] = $auth->switch_user_requested;
    $auth->render("login_form", $data);
}
