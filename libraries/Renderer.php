<?php

namespace libraries;

use Exception;

/**
 * Renderer
 * 
 * PHP Version 7.2
 * 
 * @category Renderer
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  v0.7.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */
class Renderer
{
    /**
     * Render partial file wihout checking layout switch
     * Note: Extracting arrays into variables are contained each view
     *
     * @param string $part = Partial view
     */
    public static function render_partial($part, $data = array())
    {
        extract($data);
        if (isset($GLOBALS["context"])) {
            include $GLOBALS['context']->getViewsPath() . $part . '.php';
        } else {
            throw new Exception("Unable to locate the context.");
        }
    }    
}