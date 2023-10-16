<?php

namespace classes;

// Use concerns here
use classes\concerns\RememberMe;

use DateTime;
use libraries\Helper;
use libraries\Session;
use libraries\Cookies;

/**
 * Authentication class
 * Handles the user's login and logout process
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
class Auth extends App
{
    /**
     * @var \Medoo\Medoo $db_connection The database connection
     *
     */
    public $db_connection;

    /**
     * For JSON
     *
     * @var string $status
     */
    public $status;

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        parent::__construct();

        $this->db_connection = $this->connect_database(); // if this class needed a database connection, use this line

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }

        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->doLogin();
            // Were gonna use Session library for handling $_SESSION objects
            if (Session::get('user_logged_in')) {
                // POST ACTIONS AFTER LOGIN
            }
        } elseif (isset($_GET['add_existing_user'])) {
            $this->multi_user_requested = true; // triggers multi user request
        }

        // this would log out current log session
        // but will not delete user session data
        elseif (isset($_GET['switch_user'])) {
            $this->switch_user_requested = true; // triggers switch user request
            $this->cleanUpUserSession();
        }

        // login via get data (multi-user)
        elseif (
            isset($_GET["login"])
            && (isset($_GET['u']) && !empty($_GET['u']))  // u for user_id
            && (isset($_GET['n']) && !empty($_GET['n']))
        ) { // n for name/username
            $user_id = $_GET['u'];
            $user_name = $_GET['n'];
            $this->doLoginMultiUser($user_id, $user_name);
        }

        // logout via get data (multi-user)
        elseif (
            isset($_GET["logout"])
            && (isset($_GET['u']) && !empty($_GET['u']))  // u for user_id
            && (isset($_GET['n']) && !empty($_GET['n']))
        ) { // n for name/username
            $user_id = $_GET['u'];
            $user_name = $_GET['n'];
            $this->doLogout($user_id, $user_name);
        }

        // reset password
        elseif (isset($_POST['reset_password'])) {
            $email = $_POST['email'];
            $this->forgotPassword($email);
        }

        else {
            // return to default trigger values
            $this->multi_user_requested = false;
            $this->switch_user_requested = false;
        }
    }

    /**
     * log in with post data
     *
     * @return void
     */
    private function doLogin()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
            $user_name = strip_tags($_POST['user_name']); // escape the POST stuff (ANTI INJECTION)
            $user_password = strip_tags($_POST['user_password']);
            /**
             * OLD database query, getting all the info of the selected user
             * $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "';";
             * $result_of_login_check = $this->db_connection->query($sql);
             */
            $result_of_login_check = $this->db_connection->count(
                "users",
                [
                "OR" => [
                    "user_name" => $user_name,
                    "user_email" => $user_name // username or email
                ]
                ]
            );
            // if this user exists
            if ($result_of_login_check == 1) {
                // get result row (as an object)
                // NOTE: we are really gonna use arrays. In PHP 5.4+, array is like this [], others are old array()
                $result_row = $this->db_connection->get(
                    "users",
                    [
                    //COLUMNS
                    'user_id', 'user_name', 'user_email', 'user_password',
                    'first_name', 'last_name', 'user_account_type',
                    'created', 'modified'
                    ],
                    [
                    // CONDITIONS
                    "OR" => [
                        "user_name" => $user_name,
                        "user_email" => $user_name // username or email
                    ]
                    ]
                );
                // using PHP 5.5's password_verify() function to check if the provided password fits
                // the hash of that user's password
                // https://www.php.net/manual/en/function.password-verify.php
                if (password_verify($user_password, $result_row['user_password'])) {
                    // Check FOR REST API to avoid performance drops
                    if ($this->isForJsonObject() == false) {
                        // write user data into PHP SESSION (a file on your server)
                        // $_SESSION['user_name'] = $result_row->user_name; // example

                        // Multi-user setup like google auth system
                        // TODO: Consolidate into a single object
                        $user_id = $result_row['user_id'];
                        $user_name = $result_row['user_name'];
                        $first_name = $result_row['first_name'];
                        $last_name = $result_row['last_name'];
                        Session::set('current_user', $user_id);
                        Session::set_user('user_name', $user_name);
                        Session::set_user('user_email', $result_row['user_email']);
                        Session::set_user('full_name', $first_name . " " . $last_name);
                        // Session::set_user('first_name', $first_name);
                        // Session::set_user('last_name', $last_name);
                        Session::set('user_logged_in', true);
                        Session::set_user('user_logged_in_as', $result_row['user_account_type']);

                        // Set Cookies (Remember Me)
                        if (!empty($_POST['remember'])) {
                            $remember_me = new RememberMe();
                            $remember_me->init($user_id);
                        }
                    }
                    // response
                    $this->messages[] = "Hi " . $user_name . "!";
                    $this->status = 'success';
                    // check again if the user requested json object
                    if ($this->isForJsonObject()) {
                        // FETCH USER AS JSON
                        // TODO: Convert to JWT
                        $user = array(
                            'user_id' => $result_row['user_id'],
                            'user_name' => $result_row['user_name'],
                            'name' => $result_row['first_name'] . ' ' . $result_row['last_name'],
                            'user_email' => $result_row['user_email'],
                            'created' => $result_row['created'],
                            'modified' => $result_row['modified']
                        );
                        $this->getUserJSON($user);
                    }
                } else {
                    $this->errors[] = "Wrong password. Try again.";
                    $this->status = 'wrong_password';
                }
            } else {
                $this->errors[] = "This user does not exist.";
                $this->status = 'not_exist';
            }
        }
        $this->collectResponse(array($this));
    }

    /**
     * Multi-user version of doLogin()
     * NOTE: Check documentations/comments from doLogin()
     *
     * @param $user_id
     * @param $user_name
     */
    private function doLoginMultiUser($user_id, $user_name)
    {
        // MULTI USER CHECKS
        if ($this->multi_user_status && Session::check_user($user_id)) {
            $result_of_login_check = $this->db_connection->count(
                "users",
                [
                "user_id" => $user_id
                ]
            );
            // if this user exists
            if ($result_of_login_check == 1) {
                $result_row = $this->db_connection->get(
                    "users",
                    [
                    //COLUMNS
                    'user_id', 'user_name', 'user_email', 'user_password',
                    'first_name', 'last_name', 'user_account_type',
                    'created', 'modified'
                    ],
                    [
                    // CONDITIONS
                    "OR" => [
                        "user_id" => $user_id,
                        "user_email" => $user_name // username or email
                    ]
                    ]
                );
                // Check FOR REST API to avoid performance drops
                if ($this->isForJsonObject() == false) {
                    // write user data into PHP SESSION (a file on your server)
                    // $_SESSION['user_name'] = $result_row->user_name; // example

                    // Multi-user setup like google auth system
                    $user_id = $result_row['user_id'];
                    $user_name = $result_row['user_name'];
                    $first_name = $result_row['first_name'];
                    $last_name = $result_row['last_name'];
                    Session::set('current_user', $user_id);
                    Session::set_user('user_name', $user_name, $user_id);
                    Session::set_user('user_email', $result_row['user_email'], $user_id);
                    Session::set_user('full_name', $first_name . " " . $last_name, $user_id);
                    // Session::set_user('first_name', $first_name);
                    // Session::set_user('last_name', $last_name);
                    Session::set('user_logged_in', true);
                    Session::set_user('user_logged_in_as', $result_row['user_account_type']);
                }
                // response
                $this->messages[] = "Hi " . $user_name . "!";
                $this->status = 'success';
                // check again if the user requested json object
                if ($this->isForJsonObject()) {
                    // FETCH USER AS JSON
                    $user = array(
                        'user_id' => $result_row['user_id'],
                        'user_name' => $result_row['user_name'],
                        'name' => $result_row['first_name'] . ' ' . $result_row['last_name'],
                        'user_email' => $result_row['user_email'],
                        'created' => $result_row['created'],
                        'modified' => $result_row['modified']
                    );
                    $this->getUserJSON($user);
                }
            } else {
                $this->errors[] = "This user does not exist.";
                $this->status = 'not_exist';
            }
        } else {
            // for REST response
            if ($this->isForJsonObject()) {
                $this->errors[] = "Please use the login form.";
            }
            $this->status = 'failed';
        }
        $this->collectResponse(array($this));
    }

    /**
     * perform the logout
     *
     * @param $user_id
     * @param $user_name
     */
    public function doLogout($user_id = null, $user_name = null)
    {
        // set user name for validation
        $set_user_name = Session::get_user('user_name', $user_id);
        // get users
        $users = Session::get('users');
        // count users
        $user_count = $users != null ? count($users) : 0;

        // if multi user was activated and no user id specified and it has at least one user
        if ($this->multi_user_status && $user_count == 1 && $user_id == null) { // logout all
            Session::destroy('users');
            $this->cleanUpUserSession();
            $this->messages[] = "You have been logged out";
            $this->status = 'success';
            return false;
        }
        // if multi user was activated and has user id specified
        elseif ($this->multi_user_status && Session::destroy_user($user_id)) {
            $this->cleanUpUserSession();
            // if user name was not specified
            if (empty($user_name)) {
                $this->messages[] = "You have been logged out";
            }
            // if user name was specified
            elseif ($set_user_name == $user_name) { // validate
                $this->messages[] = $user_name . " has been logged out";
            }
        }
        // if multi user was not activated
        elseif (!$this->multi_user_status) {
            Session::destroy('users');
            $this->cleanUpUserSession();
            $this->messages[] = "You have been logged out";
        }

        // JSON
        if ($this->isForJsonObject()) {
            echo Helper::json_encode(
                [
                'status' => $this->status,
                'messages' => $this->messages
                ]
            );
        }

        // BUG!
        // $this->collectResponse(array($this));
    }

    /**
     * Simply return the current state of the user's login
     *
     * @return bool user's login status
     */
    public function isUserLoggedIn(): bool
    {
        // you can use session lib
        // This returns as boolean, otherwise false
        $session_check = Session::user_logged_in();
        if ($session_check) {
            return true;
        }

        // check the remember_me in cookie
        $token = filter_input(INPUT_COOKIE, 'remember_me', FILTER_SANITIZE_STRING);

        $remember_me = new RememberMe($this->db_connection);
        if ($token && $remember_me->token_is_valid($token)) {
            $user = $remember_me->find_user_by_token($token);
            // If invalid
            if (!$user) {
                // Redirect
                header("Location: " . DIRECTORY_SEPARATOR . "?logout");
                die();
            }
        }

        return false;
    }

    public function forgotPassword($email)
    {
        if ($this->checkEmail($email)) {
            // TODO: send to email
            $code = $this->generateRandomCode($email);
            $this->messages[] = "Email sent. " . "DEBUG: " . $code; // DEBUGGING MODE
            $this->status = "success";
        } else {
            $this->errors[] = "Email doesn't exists on database";
            $this->status = "failed";
        }
        $this->collectResponse(array($this));
        return ($this->status == "success"); // return true if status was success
    }

    private function checkEmail($email)
    {
        // [fields], [conditions]
        $result = $this->db_connection->get("users", ['user_email'], ["user_email" => $email]);
        if ($result['user_email'] == $email) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate code then save to database
     */
    public function generateRandomCode($email)
    {
        $code = Helper::generateRandomCode(5); // 5 characters
        $query = $this->db_connection->insert("reset_codes", ["code" => $code, "email" => $email]);
        if (!$query) { // IF NOT SUCCESSFUL
            $this->errors[] = "Unable to save random code!";
            $this->status = "failed";

            if ($this->isForJsonObject()) {
                return Helper::json_encode(
                    [
                    'status' => $this->status,
                    'errors' => $this->errors
                    ]
                );
            }

            $this->collectResponse(array($this)); // COLLECT RESPONSE
            return false;
        }
        return $code;
    }

    /**
     * Verifies reset code for password change
     *
     * @return bool
     */
    public function verifyResetCode($email, $reset_code)
    {
        // binded params in query (ANTI SQL INJECTION)
        $pdo = $this->db_connection->pdo;
        $sql = "SELECT code, created FROM reset_codes WHERE code = :code AND email = :email LIMIT 1";
        $query = $pdo->prepare($sql);
        $query->bindParam(":code", $reset_code);
        $query->bindParam(":email", $email);
        $result = $query->execute();
        $timestamp_one_hour_ago = time() - 3600; // 3600 seconds = 1 hour

        if ($result) {
            $result = $query->fetch(); // overwrite for now
            $datetime = new DateTime($result['created']);
            $timestamp_from_query = $datetime->format("U");
            // \libraries\Debugger::dump($timestamp_from_query);
            if (($result['code'] == $reset_code) && ($timestamp_from_query > $timestamp_one_hour_ago)) {
                $this->messages[] = "Verified. Please reset your password now.";
                $this->status = "success";
            } else {
                $this->errors[] = "Sorry, Reset code was already expired.";
                $this->status = "failed";
            }
        } else {
            $this->errors[] = "Sorry, Unable to verify your account. Please check your code from e-mail.";
            $this->status = "failed";
        }

        $this->collectResponse(array($this));
        // TODO: Delete reset code when successfully verified
        return ($this->status == "success"); // return true if status was success
    }

    /**
     * Clean up current user session statuses
     * but it will not erase any user session data
     *
     * Note: Remember Me is currently not supported on Multi-user setup
     */
    public function cleanUpUserSession()
    {
        Session::set('current_user', null);
        Session::set('user_logged_in', false);

        // remove the remember_me cookie
        if (isset($_COOKIE['remember_me'])) {
            Cookies::set('remember_me', null, -1);
        }
    }

    /**
     * Get users data in JSON format
     *
     * @param array $user
     */
    private function getUserJSON(array $user)
    {
        // gonna use the json library
        echo Helper::json_encode(
            [
            'status' => $this->status,
            'errors' => $this->errors,
            'messages' => $this->messages,
            'user' => $user
            ]
        );
    }
}
