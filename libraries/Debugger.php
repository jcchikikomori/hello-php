<?php

namespace libraries;

/**
 * Debugger class
 *
 * PHP version 7.2
 *
 * @category Debugger
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
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
