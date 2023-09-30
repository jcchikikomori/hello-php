<?php

/**
 * The Application's Home Page or Root Directory
 *
 * PHP version 8.1
 *
 * @category Home
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  TBA
 * @link     https://github.com/jcchikikomori/hello-php
 */

require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/concerns/RememberMe.php";
require_once "classes/handlers/URI.php";

$context = new classes\Auth();

// collect response from Auth constructor
// Note: Auth was extended from App class so we can call functions from the App class
$context->collectResponse(array($context));
// if user logged in (using Auth class)
if ($context->isUserLoggedIn()) {
    // put data here using App's render()
    // put "auth" to show $auth on output, otherwise undefined
    $context->render("templates/partials/logged_in");
}
// not logged in
elseif (!$context->isUserLoggedIn()) {
    $context->render("templates/partials/login_form");
}
