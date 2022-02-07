<?php

namespace classes;

use libraries\Helper;

/**
 * Registration class
 * Handles the user registration
 *
 * PHP version 7.2
 *
 * @category Registration
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  Release: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class Registration extends Auth
{
    /**
     * @var \Medoo\Medoo $db_connection The database connection
     *
     */
    public $db_connection;

    /**
     * Init the collection of error messages
     *
     * @var array Error messages array
     */
    public $errors = array();

    /**
     * Init the collection of success / neutral messages
     *
     * @var array Messages array
     */
    public $messages = array();

    /**
     * For JSON
     *
     * @var string $status
     */
    public $status;

    /**
     * The function "__construct()" automatically starts
     * whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        // Load parent constructor
        parent::__construct();

        $this->db_connection = $this->connect_database();

        // This is a example how to debug your query
        // print_r($this->db_connection->debug()->select("user_types", '*')); die();

        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * Get User Types
     *
     * @return Array user types associative array
     */
    public function getUserTypes()
    {
        // Setting up columns as an empty array, can automatically sets as "*"
        // Example: SELECT * FROM database_name.user_types;
        // Source: https://medoo.in/api/select
        return $this->db_connection->select("user_types", ["user_type", "type_desc"]);
    }

    /**
     * Handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     *
     * @return mixed
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Password and password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username is invalid: only a-Z and numbers and 2 to 64 characters are allowed";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } else {
            $user_name = strip_tags($_POST['user_name'], ENT_QUOTES);
            $first_name = strip_tags($_POST['first_name'], ENT_QUOTES);
            $middle_name = strip_tags($_POST['middle_name'], ENT_QUOTES);
            $last_name = strip_tags($_POST['last_name'], ENT_QUOTES);
            $user_type = strip_tags($_POST['user_type'], ENT_QUOTES);
            $user_email = strip_tags($_POST['user_email'], ENT_QUOTES);
            // we're not gonna escape this as long as browsers already recognized this kind of field like password
            $user_password = $_POST['user_password_new'];
            // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
            // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
            // PHP 5.3/5.4, by the password hashing compatibility library
            $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
            /**
             * Check if user or email address already exists
             * GONNA USE MEDOO TO MAKE THIS EASY. USING COUNT TO CHECK IF WE HAVE USER LIKE THIS
             *
             * @link http://medoo.in/api/where, http://medoo.in/api/count
             */
            $user_check_count = $this->db_connection->count(
                "users",
                [
                "OR" => [
                      "user_name" => $user_name,
                      "user_email" => $user_email
                ]
                ]
            );
            /**
             * COMPARED TO THIS
             * "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
             */
            if ($user_check_count > 0) {
                $this->errors[] = "Sorry, that username / email address is already taken.";
                $this->status = "failed";
            } else {
                // format current date
                $current_date = date('Y-m-d H:i:s');
                // write new user's data into database
                $this->db_connection->insert(
                    "users",
                    [
                    "user_name" => $user_name,
                    "first_name" => $first_name,
                    "middle_name" => $middle_name,
                    "last_name" => $last_name,
                    "user_account_type" => $user_type,
                    "user_password" => $user_password_hash,
                    "user_email" => $user_email,
                    "created" => $current_date,
                    "modified" => $current_date
                    ]
                );
                // The good thing in Medoo is, you can check last actions like check for errors, etc.
                // after insertion, we're gonna verify if the new user is created in DB
                if (!empty($this->db_connection->id())) {
                    $this->messages[] = "Your account has been created successfully. You can now log in.";
                    $this->status = "success";
                } else {
                    $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    $this->status = "failed";
                }
            }
        }
        $this->collectResponse(array($this));
    }

    /**
     * Add some process after the end of processes inside this class
     * You can put your json response here
     */
    public function __destruct()
    {
        // JSON TEST
        if ($this->isForJsonObject()) {
            $this->setLayouts(false);
            // EXAMPLE HERE
            echo Helper::json_encode(
                [
                'status' => $this->status,
                'errors' => $this->errors,
                'messages' => $this->messages
                //other_stuffs,
                //even_callbacks,
                ]
            );
        }
    }
}
