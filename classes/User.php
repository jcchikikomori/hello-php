<?php

namespace classes;

use concerns\RememberMe;

/**
 * User class
 * User management
 *
 * PHP version 7.2
 *
 * @category User
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */
class User extends App
{
    /**
     * @var \Medoo\Medoo $db_connection The database connection
     *
     */
    public $db_connection;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        parent::__construct();
        $this->db_connection = $this->connect_database();
    }

    /**
     * Sends new password to user or generates reset code
     */
    public function resetPassword($post)
    {
        // SOON
        $user_email = $post['email'];
        $user_password = $post['new_password'];
        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
        $user_count = $this->db_connection->count(
            "users",
            [
            "user_email" => $user_email
            ]
        );
        if ($user_count > 0) {
            // format current date
            $current_date = date('Y-m-d H:i:s');
            // write new user's data into database
            $result = $this->db_connection->update(
                "users",
                [
                "user_password" => $user_password_hash,
                "modified" => $current_date
                ],
                [
                "user_email" => $user_email,
                ]
            );
            if ($result) {
                 $this->messages[] = "Your password has been updated successfully. You can now log in.";
                 $this->status = "success";
            } else {
                $this->errors[] = "Sorry, we are unable to update your password. Please try again.";
                $this->status = "failed";
            }
        }
        $this->collectResponse(array($this));
        return ($this->status == "success"); // return true if status was success
    }
}
