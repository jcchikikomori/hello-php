<?php

/**
 * Forgot Password root file
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

 // checking requirements first before using
require_once "classes/App.php";
require_once "classes/Auth.php";
require_once "classes/User.php";

$auth = new classes\Auth();
$user = new classes\User();

// Immediate Password Reset Action
if (isset($_GET['resetpasswordwithcode'])) {
    if (isset($_POST['reset_password_with_code'])) {
        $email = $_POST['email'];
        $code = $_POST['reset_code'];
        if ($auth->verifyResetCode($email, $code)) {
            // for now, email is required
            $data = array(
                'email_address' => $email,
                'reset_code' => $code
            );
            // this should be a success page
            $auth->render("forgot_password_success", $data);
            exit();
        }
    } else {
        // default page
        // this should be a success page
        $auth->render("forgot_password_code");
        exit();
    }
    // RESETTING PASSWORD
} elseif (isset($_POST['reset_new_password'])) {
    $email = $_POST['email'];
    $code = $_POST['reset_code'];
    $data = array(
        'email_address' => $email,
        'reset_code' => $code
    );

    $result = $user->resetPassword($_POST);
    if ($result) {
        $auth->render("login_form", $data);
        exit();
    } else {
        $auth->render("forgot_password_success", $data);
        exit();
    }
}

/**
 * You can add $app->multi_user_status condition
 * if you want a single-user mode
 */
if (!$auth->isUserLoggedIn()) {
    // DEBUG: TRY THIS ONE (CODE GENERATOR). SAVES TO DATABASE
    // echo "<h2>".$auth->generateRandomCode(5)."</h2>";
    $auth->render("forgot_password");
} else {
    // error reporting
    $auth->error("Must be logged out first.");
}
