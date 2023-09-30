<?php

/**
 * hello-php by jcchikikomori
 *
 * DO NOT MAKE ANY CHANGES HERE UNLESS NECESSARY AND PEER REVIEW IS A MUST
 *
 * @link https://github.com/jcchikikomori/hello-php
 * @license http://opensource.org/licenses/MIT MIT License
 */

// load required files
require_once "classes/App.php";
require_once "classes/concerns/RememberMe.php";
require_once "classes/handlers/URI.php";

// Implement URI handling along with the specified context
$URI = new classes\handlers\URI(new classes\App());
$context = $URI->getContext();

// Exit the process already
if ($URI->isClassProcessed()) {
    exit();
}
