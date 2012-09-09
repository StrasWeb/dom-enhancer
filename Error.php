<?php
/**
 * Error class
 *
 * PHP Version 5.3.6
 * 
 * @category Class
 * @package  DOMenhancer
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     https://code.google.com/p/dom-enhancer/
 */
 /**
 * Custom error handler
 *
 * PHP Version 5.3.6
 * 
 * @category Class
 * @package  DOMenhancer
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     https://code.google.com/p/dom-enhancer/
 */
class DOMenhancer_Error
{
    static $tag;
    static $debug=false;
    /**
     * Custom error handler function
     * Displays the error only if $debug is true
     * 
     * @param int    $errno   Error type
     * @param string $errstr  Error message
     * @param string $errfile Error file (not used)
     * @param string $errline Error line (not used)
     * 
     * @return bool
     * */
    static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if ($errno==E_USER_WARNING
            || $errno==E_USER_ERROR
            || $errno==E_USER_NOTICE
        ) {
            self::displayError($errstr, $errno);
        }
        if (self::$debug) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Displays an error
     * (in HTML if possible, in plain text if not)
     * 
     * @param string $errstr Error message
     * @param int    $errno  Error type
     * 
     * @return void
     * */
    static function displayError($errstr, $errno)
    {
        global $dom;
        if (isset($dom) && isset(self::$tag)) {
            if ($errno==E_USER_WARNING || $errno==E_USER_ERROR) {
                $class="error";
            } else if ($errno==E_USER_NOTICE) {
                $class="modified";
            } else {
                $class="unknownError";
            }
            self::$tag->addElement("div", $errstr, array("class"=>$class));
        } else {
            print(htmlentities($errstr));
        }
    }
}
set_error_handler("DOMenhancer_Error::errorHandler");
?>
