<?php

namespace libraries;

/**
 * Debugger class
 *
 * PHP version 7.2
 *
 * @category Debugger
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  Release: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class Debugger
{
    /**
     * Dumps a variable
     * TODO: Make a environment setup for developers
     *
     * @param  [type] $obj
     * @return void
     */
    public static function dump($obj)
    {
        echo var_dump($obj);
    }
}
