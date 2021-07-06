<?php

namespace Simphotonics\Utils;

/**
 * @author    D Reschner <d.reschner@simphotonics.com>
 * @copyright 2016 Simphotonics
 * 
 * Description: Web utility methods.
 */
class WebUtils
{
    /**
     * Returns 'baseURI'.
     *
     * @method baseURI
     * @return string  baseUri
     * Examples:
     *     http:://google.com/ => google
     *     /index.php          => index
     *     user/logout/        => logout
     *     user/post/?msg='...'=> post
     */
    public static function baseURI()
    {
        // Check if uri contains a query.
        $uri = $_SERVER['REQUEST_URI'];


        $qmIsHere  = strpos($uri, '?');
        $uri  = ($qmIsHere === false) ? $uri :
            substr($uri, 0, $qmIsHere);
        // Get file name
        return          pathinfo($uri)['filename'];
    }

    public static function getURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
