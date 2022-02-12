<?php

namespace classes;

use Gregwar\Captcha\CaptchaBuilder;

/**
 * Captcha class
 * Utility class for everything but Captcha
 *
 * TODO: Using Google's reCAPTCHA feature
 *
 * PHP version 7.2
 *
 * @category Captcha
 * @package  hello-php
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  0.5.1-alpha
 * @link     https://github.com/jcchikikomori/hello-php
 */
class Captcha extends App
{
    /**
     * Generates the captcha, "returns" a real image,
     * this is why there is header('Content-type: image/jpeg')
     * Note: This is a very special method, as this is echoes out binary data.
     * Eventually this is something to refactor
     */
    public function generateCaptcha()
    {
        // create a captcha with the CaptchaBuilder lib
        $builder = new CaptchaBuilder();
        $builder->build();

        // write the captcha character into session
        $_SESSION['captcha'] = $builder->getPhrase();

        // render an image showing the characters (=the captcha)
        header('Content-type: image/jpeg');
        $builder->output();
    }

    /**
     * Checks if the entered captcha is the same like the one from the rendered image which has been saved in session
     *
     * @return bool success of captcha check
     */
    private function checkCaptcha()
    {
        if (isset($_POST["captcha"]) and ($_POST["captcha"] == $_SESSION['captcha'])) {
            return true;
        }
        // default return
        return false;
    }
}
