<?php

/**
 * hello-php by jcchikikomori
 *
 * @link https://github.com/jcchikikomori/hello-php
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load required files
require_once "classes/App.php";

// load the login class then instantiate again
require_once "classes/Auth.php";
$auth = new classes\Auth();

// collect response from Auth constructor
// Note: Auth was extended from App class so we can call functions from the App class
$auth->collectResponse(array($auth));
// if user logged in (using Auth class)
if ($auth->isUserLoggedIn()) {
    // put data here using App's render()
    // put "auth" to show $auth on output, otherwise undefined
    $auth->render("templates/partials/logged_in");
}
// not logged in
elseif (!$auth->isUserLoggedIn()) {
    $auth->render("templates/partials/login_form");
}
