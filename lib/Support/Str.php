<?php

namespace Xedi\SendGrid\Support;

/**
 * String Utilities
 *
 * @package Xedi\SendGrid\Support;
 * @author  Chris Smith <chris@xedi.com>
 */
class Str
{
    /**
     * Convert the given string to title case.
     *
     * @param string $value Value to be converted
     *
     * @return string
     */
    public static function title($value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string       $haystack String to use
     * @param string|array $needles  Needle(s) to check for
     *
     * @return bool
     */
    public static function contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
