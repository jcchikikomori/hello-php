<?php

namespace classes\concerns;

use classes\App;
use libraries\Cookies;
use PDOStatement;

/**
 * Remember Me inherited class for the following:
 * - classes\Auth
 * Based on tutorial: https://www.phptutorial.net/php-tutorial/php-remember-me/
 *
 * PHP version 8.0
 *
 * @category User
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  Release: 0.7-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class RememberMe extends App
{
    /**
     * @var \Medoo\Medoo $db_connection The database connection
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
     *
     * @param \Medoo\Medoo $db_connection To re-use database connection (optional)
     */
    public function __construct($db_connection = null)
    {
        parent::__construct();
        if (isset($db_connection)) {
            $this->db_connection = $db_connection;
            return;
        }

        $this->db_connection = $this->connect_database();
    }

    /**
     * The init() function saves the login for a user for a specified number of days.
     * By default, it remembers the login for 30 days.
     * This function does the following:
     *
     * First, generate selector, validator, and token (selector:validator)
     * Second, insert a new row into the access_tokens table.
     * Third, set a cookie with the specified expiration time.
     *
     * @param integer $user_id
     * @param integer $day
     * @return void
     */
    public function init(int $user_id, int $day = 30)
    {
        [$selector, $validator, $token] = $this->generate_tokens();
        // remove all existing token associated with the user id
        $this->delete_user_token($user_id);
        // set expiration date
        $expired_seconds = time() + 60 * 60 * 24 * $day;
        // insert a token to the database
        $hash_validator = password_hash($validator, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', $expired_seconds);

        if ($this->insert_user_token($user_id, $selector, $hash_validator, $expiry)) {
            Cookies::set('remember_me', $token, $expired_seconds);
        }
    }

    /**
     * Undocumented function
     *
     * @param integer $user_id
     * @param string $selector
     * @param string $hashed_validator
     * @param string $expiry
     * @return boolean
     */
    public function insert_user_token(
        int $user_id,
        string $selector,
        string $hashed_validator,
        string $expiry
    ): bool {
        $this->db_connection->insert(
            "access_tokens",
            [
            "user_id" => $user_id,
            "selector" => $selector,
            "hashed_validator" => $hashed_validator,
            "expiry" => $expiry
            ]
        );
        if (!empty($this->db_connection->id())) {
            $this->messages[] = "Remember Me, OK?";
            $this->status = "success";
        } else {
            $this->errors[] = "Unable to remember your session.";
            $this->status = "failed";
        }
        $this->collectResponse(array($this));
        return ($this->status == "success"); // return true if status was success
    }

    /**
     * Undocumented function
     *
     * @param string $selector
     * @return array
     */
    public function find_user_token_by_selector(string $selector): array
    {
        $result_row = $this->db_connection->get(
            "access_tokens",
            //COLUMNS
            ['id', 'selector', 'hashed_validator', 'user_id', 'expiry'],
            [
            // CONDITIONS
            "AND" => [
            "selector" => $selector,
            "expiry[>=]" => "now()"
            ]
            ]
        );
        return $result_row;
    }

    /**
     * Undocumented function
     *
     * @param integer $user_id
     * @return PDOStatement|null
     */
    public function delete_user_token(int $user_id): PDOStatement|null
    {
        $result = $this->db_connection->delete(
            "access_tokens",
            [
            "user_id" => $user_id
            ]
        );
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param string $token
     * @return array|null
     */
    public function find_user_by_token(string $token): array|null
    {
        $tokens = $this->parse_token($token);
        // Guard clause
        if (!$tokens) {
            return null;
        }

        $selector = $tokens[0];

        // Note: get($table, $join, $columns, $where)
        // Another note: Just set variables separately if you got confused
        $table = "access_tokens";
        $join = ["[>]users" => "user_id"];
        $columns = ["users.user_id", "user_name"];
        $where = [
        "AND" => [
        "selector" => $selector,
        "expiry[>=]" => "now()"
        ]
        ];
        $result_row = $this->db_connection->get($table, $join, $columns, $where);
        return $result_row;
    }

    /**
     * Parse the token to get the selector and validator
     *
     * @param string $token
     * @return boolean
     */
    public function token_is_valid(string $token): bool
    {
        [$selector, $validator] = $this->parse_token($token);
        $tokens = $this->find_user_token_by_selector($selector);
        // Guard clause
        if (!$tokens) {
            return false;
        }
        return password_verify($validator, $tokens['hashed_validator']);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function generate_tokens(): array
    {
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));
        return [$selector, $validator, $selector . ':' . $validator];
    }

    /**
     * Undocumented function
     *
     * @param string $token
     * @return array|null
     */
    public function parse_token(string $token): ?array
    {
        $parts = explode(':', $token);
        if ($parts && count($parts) == 2) {
            return [$parts[0], $parts[1]];
        }
        return null;
    }
}
