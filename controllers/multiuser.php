<?php

/**
 * Multi-user index
 * This is only works with multi-user switch on
 *
 * PHP version 7.2
 *
 * @category Auth
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */

namespace controllers;

// Core components first such as main classes then load dependencies
// then Instantiate the class to use it
require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/concerns/RememberMe.php";
require_once "classes/handlers/URI.php";

// load the auth class then instantiate again
$context = new \classes\Auth();

// either multi-user login or switch user (requires multi-user too)
if (
    ($context->isUserLoggedIn() && $context->multi_user_requested) ||
    (!$context->isUserLoggedIn() && $context->switch_user_requested)
) {
    // then render
    $data['multi_user_requested'] = $context->multi_user_requested;
    $data['switch_user_requested'] = $context->switch_user_requested;
    $context->render("templates/partials/login_form", $data);
}
