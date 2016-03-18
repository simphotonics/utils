<?php

namespace Simphotonics\Utils;

/**
 * @author D Reschner <d.reschner@simphotonics.com>
 * @copyright 2015 Simphotonics
 * Description: Utility functions for string manipulation.
 */

class StringUtils
{

    const OMIT_EMPTY_LINES = 0;

    const KEEP_EMPTY_LINES = 1;


    /**
     * Converts a boolean to a string.
     * @param  bool   $bool
     * @return string
     */
    public static function bool2str($bool = true)
    {
        if ($bool === false) {
            return 'FALSE';
        } else {
            return 'TRUE';
        }
    }
            
    /**
     * Encloses and input string with double quotes.
     * @param  string $val
     * @param  string $q
     * @return string
     */
    public static function quote($val = "", $q = "\"")
    {
        if (is_string($val)) {
            return $q . $val . $q;
        } elseif (is_numeric($val)) {
            return $val;
        } elseif (is_array($val)) {
            return "StringUtils::quote returned 'array'! ";
        } else {
            return $q . $val . $q;
        }
    }
        
    /**
     * Generic explode function.
     * @param  string $input
     * @param  array $delims Array containing delimiter characters.
     * @return array
     */
    public static function explodeGeneric($input = '', array $delims = [' '])
    {
        foreach ($delims as $delim) {
            $input = str_replace($delim, ' ', $input);
        }
        $input = preg_replace('/\s\s+/', ' ', $input);
        $input = trim($input);
        $out = explode(' ', $input);
        return $out;
    }
    
    /**
     * Explodes string into lines of text using
     * the characters: Windows \r\n, Unix \n, Mac \r.
     * @param  string  $input
     * @param  boolean $flag  OMIT_EMPTY_LINES|KEEP_EMPTY_LINES
     * @return array
     */
    public static function explodeTextlines(
        $input,
        $flag = SELF::OMIT_EMPTY_LINES
    ) {
    
        $out = explode(PHP_EOL, $input);
        if ($flag) {
            return $out;
        }
        // Reject empty words
        foreach ($out as $pos => $word) {
            if (empty($word)) {
                unset($out[$pos]);
            }
        }
        return $out;
    }
    
   /**
    * Converts preformatted text to pure html encoded text.
    * (Linebreaks => <br/>, Multiple spaces => n X &nbsp;)
    * @param  string  $input
    * @param  boolean $decontaminate
    * @return string
    */
    public static function pre2html($input = '', $decontaminate = true)
    {
        // O) Decontaminate
        if ($decontaminate) {
            $input = htmlentities($input);
        }
        // I) Replace line breaks.
        $input = str_replace(PHP_EOL, '<br/>', $input);
        // II) Replace space characters.
        $input = str_replace('  ', '&nbsp;&nbsp;', $input);
        // III) Replace tab characters.
        $input = str_replace("\t", '&nbsp;&nbsp;', $input);
        return $input;
    }
}
