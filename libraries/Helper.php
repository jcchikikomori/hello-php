<?php

namespace libraries;

/**
 * Combined needed helper functions
 *
 * PHP version 7.2
 *
 * @category Helper
 * @package  PHP7Starter
 * @author   John Cyrill Corsanes <jccorsanes@protonmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @version  Release: 0.51-alpha
 * @link     https://github.com/jcchikikomori/php7-starter
 */
class Helper
{
    /**
     * Recommended REST values. You can change this if you wish
     *
     * @param  array $data - any of data or arrays you wish
     * @return string - JSON
     */
    public static function json_encode(array $data = [])
    {
        $array = [];
        if (!empty($data)) {
            // you can change this based on App class
            foreach ($data as $dat => $key) {
                $array[$dat] = $key; // much better!
            }
        }
        return json_encode($array); // return as response
    }

    /**
     * @param  $json
     * @return mixed
     */
    public static function json_decode($json)
    {
        return json_decode($json);
    }

    /**
     * Display Messages
     * TODO: Expose Global Variables for layouts
     * TODO: Use app context instead
     */
    public static function getFeedback()
    {
        $obj = Session::get('response');
        if (isset($obj)) {
            // Explicit call to Auth class (assumed Auth class is loaded)
            if (!empty($obj['messages'])) {
                $data = array("_notification_messages" => $obj['messages']);
                $file = "templates/partials/notification";
                // TODO: Report this error if context doesn't exists
                if (isset($GLOBALS["context"])) {
                    $GLOBALS["context"]->render_partial($file, $data);
                }
            }
        }
        Session::destroy('response');
    }

    /**
     * Generate a random string
     * jcchikikomori MOD: Must be All Caps
     *
     * Concept: https://3v4l.org/KKlc3
     *
     * @source: https://stackoverflow.com/questions/48124/generating-pseudorandom-alpha-numeric-strings
     * @param   int $length How many characters do we want?
     * @return  string
     */
    public static function generateRandomCode($length)
    {
        $key = "";
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return strtoupper($key);
    }
}
