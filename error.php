<?php

/**
 * Error Handling variable file
 * Currently for Apache only
 * TODO: NGINX
 *
 * PHP version 7.2
 *
 * @category Error
 * @package  hello-php
 * @author   Chris Coyier <chriscoyier@gmail.com>
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @source   https://css-tricks.com/snippets/php/error-page-to-handle-all-errors/
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */

require_once "classes/App.php";
$app = new classes\App();

$status = $_SERVER['REDIRECT_STATUS'];
$codes = array(
    403 => array(
        '403 Forbidden',
        'The server has refused to fulfill your request.'
    ),
    404 => array(
        '404 Not Found',
        'The document/file requested was not found on this server.'
    ),
    405 => array(
        '405 Method Not Allowed',
        'The method specified in the request is not allowed.'
    ),
    408 => array(
        '408 Request Timeout',
        'Your browser failed to send a request in the time allowed by the server.'
    ),
    500 => array(
        '500 Internal Server Error',
        // TODO: Better documentation on this one
        'The request was unsuccessful by the server.'
    ),
    502 => array(
        '502 Bad Gateway',
        'The server received an invalid response while trying to request.'
    ),
    504 => array(
        '504 Gateway Timeout',
        'The upstream server failed to send a request in the time allowed.'
    ),
);
$data['error_title'] = $codes[$status][0];
$data['error_message'] = $codes[$status][1];

// $core->render("error.php", NULL, $data); // unified error page
$app->error($data['error_message'], $data);
