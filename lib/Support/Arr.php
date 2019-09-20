<?php

namespace Xedi\SendGrid\Support;

use ArrayAccess;

/**
 * Array utilities and helpers
 *
 * @package Xedi\SendGrid\Support
 * @author  Chris Smith <chris@xedi.com>
 */
class Arr
{
    /**
     * Determine whether the given value is array accessible.
     *
     * @param mixed $value Value to be assessed
     *
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    /**
     * Determine if the given key exists in the provided array.
     *
     * @param \ArrayAccess|array $array Provided array or Object implementing ArrayAccess
     * @param string|int         $key   Provided key
     *
     * @return bool
     */
    public static function exists($array, $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param \ArrayAccess|array $array   Provided array or class implementing ArrayAccess
     * @param string             $key     Key of the desired object
     * @param mixed              $default Value to returned if no item is found
     *
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (! static::accessible($array)) {
            return value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if (static::exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return value($default);
            }
        }

        return $array;
    }
}
