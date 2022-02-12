<?php

/**
 * Registration init file
 *
 * PHP version 7.2
 *
 * @category Registration
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  GIT: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */

require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/Registration.php";
require_once "classes/concerns/RememberMe.php";

$context = new classes\Registration();

// Now put your data here and include in render()
$data = ['user_types' => $context->getUserTypes()];
// You can add $app->multi_user_status condition
// if you want a single-user mode
if (!$context->isUserLoggedIn()) {
    $context->render("templates/partials/register", $data);
} else {
    // error reporting
    $context->error("Must be logged out first.");
}
