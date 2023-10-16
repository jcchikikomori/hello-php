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
        // Establishing up global context
        $GLOBALS["context"] = $app;
        // Get the current URI without query parameters
        $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
        // Define a base directory for your PHP files
        $controller_dir = $this->app->getControllersDir();

        // Tentative condition
        // var_dump($request_uri);
        if ($request_uri == DIRECTORY_SEPARATOR) {
            $file_path = $controller_dir . 'home.php';
            // Check if the file exists
            // var_dump($file_path);
            if (file_exists($file_path)) {
                // $this->app->messages[] = "File exists";
                require_once($file_path);
            } else {
                // Page not found, return a 404 response
                $this->pageNotFound();
            }
        } elseif ($request_uri !== DIRECTORY_SEPARATOR) {
            // Remove leading and trailing slashes, if any
            $request_uri = strtolower(trim($request_uri, DIRECTORY_SEPARATOR));
            // echo var_dump($request_uri);
            // Construct the full path to the PHP file based on the URI
            $file_path = $controller_dir . $request_uri . '.php';
            // Check if the file exists
            // var_dump($file_path);
            if (file_exists($file_path)) {
                // $this->app->messages[] = "File exists";
                require_once($file_path);
            } else {
                // Page not found, return a 404 response
                $this->pageNotFound();
            }
        } else {
            header("Location: " . DIRECTORY_SEPARATOR);
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

    private function pageNotFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo "404 Page Not Found";
        exit(0);
    }
}
