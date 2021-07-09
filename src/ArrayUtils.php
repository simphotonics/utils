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
     * Returns the array offset corresponding to an array key or false
     * if the key does not exist.
     *
     * @param  Array      $arr
     * @param  string|int $key
     * @return int|bool
     */
    public static function key2offset(array &$arr, string|int $key): int|bool
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
    public static function offset2key(array &$arr, int $offset): int|bool
    {
        $keys = array_keys($arr);
        return isset($keys[$offset]) ? $keys[$offset] : false;
    }

    /**
     * Returns an array containing random integers:
     * $first <= random int <= $last.
     *
     * @param  int     $length
     * @param  integer $first
     * @param  integer $last
     * @return array
     */
    public static function randArray(
        int $length,
        int $first = 0,
        int $last = 255
    ): array {
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
    public static function mean(array $input): float|null
    {
        if (!is_array($input) || empty($input)) {
            return null;
        }
        return array_sum($input) / sizeof($input);
    }


    /**
     * Returns the standard deviation of numeric array values.
     *
     * @param  array $arr
     * @return float|null
     */
    public static function stDeviation(array $arr): float|null
    {
        if (!is_array($arr) || sizeof($arr) < 2) {
            return null;
        }
        $mean = self::mean($arr);
        array_walk(
            $arr,
            function (&$x) use ($mean) {
                $x = ($x - $mean) * ($x - $mean);
            }
        );
        return sqrt(array_sum($arr) / (sizeof($arr) - 1));
    }
}
