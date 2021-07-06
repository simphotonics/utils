<?php

namespace Simphotonics\Utils;

/**
 * @author    D Reschner <d.reschner@simphotonics.com>
 * @copyright 2015 Simphotonics
 * Description: Array helper functions.
 */
class ArrayUtils
{
    /**
     * Return the array offset corresponding to an array key.
     *
     * @param  Array      $arr
     * @param  string|int $key
     * @return int
     */
    public static function key2offset(array &$arr, $key)
    {
        return isset($arr[$key]) ? array_flip(array_keys($arr))[$key] : false;
    }

    /**
     * Returns the array key corresponding to a given array offset.
     *
     * @param  Array &$arr
     * @param  int   $offset
     * @return string|int
     */
    public static function offset2key(array &$arr, $offset)
    {
        $keys = array_keys($arr);
        return isset($keys[$offset]) ? $keys[$offset] : false;
    }

    /**
     * Returns an array of random integers: $first <= random int <= $last.
     *
     * @param  int     $length
     * @param  integer $first
     * @param  integer $last
     * @return array
     */
    public static function randArray($length, $first = 0, $last = 255)
    {
        for ($i = 0; $i < $length; $i++) {
            $arr[] = mt_rand($first, $last);
        }
        return $arr;
    }

    /**
     * Returns the mean of numeric array values.
     *
     * @param  array $arr
     * @return float|null
     */
    public static function mean(array $arr)
    {
        if (!is_array($arr)) {
            return null;
        }
        return array_sum($arr)/sizeof($arr);
    }


     /**
      * Returns the standard deviation of numeric array values.
      *
      * @param  array $arr
      * @return float|null
      */
    public static function stDeviation(array $arr)
    {
        if (!is_array($arr) || sizeof($arr) < 2) {
            return null;
        }
        $mean = self::mean($arr);
        array_walk(
            $arr, function (&$x) use ($mean) {
                $x = ($x - $mean)*($x - $mean);

            }
        );
        return sqrt(array_sum($arr)/(sizeof($arr)-1));
    }
}
