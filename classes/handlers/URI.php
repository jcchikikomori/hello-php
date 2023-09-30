<?php

namespace classes\handlers;

use classes\App;

/**
 * URI Handler
 * TODOS:
 * 1. Handle $REQUEST_URL objects then match the value with views.
 * 2. Then handle validation; If the controller was not found, redirect to error page, then return as 404;
 *    Otherwise, execute the class being located.
 * 3. Trigger an HTTP Error with the nice page with design.
 *
 * PHP version 8.1
 *
 * @category URI
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  TBA
 * @link     https://github.com/jcchikikomori/hello-php
 */
class URI
{
    /**
     * @var App Application class
     */
    protected $app;
    /**
     * @var string Default views path
     */
    protected $views_path;

    /**
     * @var bool To tell the context to stop processing now
     */
    protected $processed;

    /**
     * @param App $app
     */
    public function __construct($app)
    {
        // Reuse the application
        $this->app = $app;

        // Get the current URI without query parameters
        $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
        // Tentative condition
        // if ($request_uri == DIRECTORY_SEPARATOR && $request_uri !== "/index.php" &&
        //     isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'], '?') !== false) {

        // if ($request_uri !== "/" &&
        //     isset($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'], '?') !== false) {
        //     // Remove leading and trailing slashes, if any
        //     $request_uri = strtolower(trim($request_uri, DIRECTORY_SEPARATOR));
        //     // echo var_dump($request_uri);
        //     // Define a base directory for your PHP files
        //     $controller_dir = $this->app->getControllersDir();
        //     // Construct the full path to the PHP file based on the URI
        //     $file_path = $controller_dir . DIRECTORY_SEPARATOR . $request_uri . '.php';
        //     // Check if the file exists
        //     if (file_exists($file_path)) {
        //         $this->app->messages[] = "File exists";
        //     } else {
        //         // Page not found, return a 404 response
        //         // pageNotFound();
        //         header("HTTP/1.0 404 Not Found");
        //         echo "404 Page Not Found";
        //         exit(0);
        //     }
        // } else {
        // }

        // Tentative move
        // TODO: Move all of these to /controllers dir
        if ($request_uri === "/") {
            // $this->app->messages[] = "Home Page";
            include_once($this->app->getBaseDir() . "home.php");
            $this->processed = true;
        } elseif ($request_uri === "/forgotpassword") {
            include_once($this->app->getBaseDir() . "forgotpassword.php");
            $this->processed = true;
        } elseif ($request_uri === "/register") {
            include_once($this->app->getBaseDir() . "register.php");
            $this->processed = true;
        } elseif ($request_uri === "/multiuser") {
            $this->app->messages[] = "Home Page";
            include_once($this->app->getBaseDir() . "multiuser.php");
            $this->processed = true;
        } elseif ($request_uri === "/logout") {
            include_once($this->app->getBaseDir() . "logout.php");
            $this->processed = true;
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Page Not Found";
            exit();
        }
    }

    public function getContext()
    {
        return $this->app;
    }

    public function isClassProcessed()
    {
        return $this->processed;
    }
}
