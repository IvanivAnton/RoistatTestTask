<?php

namespace Parser\Services;

class ArrayService
{
    /**
     * Checks if a value exists in an array
     * @param mixed $needle
     * @param array $haystack
     * @param bool $strict
     * @return bool
     */
    public function inArray($needle, array $haystack, bool $strict = false): bool
    {
        return in_array($needle, $haystack, $strict);
    }

    /**
     * Checks if the given key or index exists in the array
     * @param $key
     * @param $array
     * @return bool
     */
    public function arrayKeyExists($key, $array): bool
    {
        return array_key_exists($key, $array);
    }

    /**
     * (PHP 5 >= 5.2.0, PECL json >= 1.2.0)<br>
     * Returns the JSON representation of a value
     * @param mixed $value
     * @param int $flags
     * @param int $depth
     * @return false|string
     */
    public function jsonEncode($value, int $flags = 0, int $depth = 512)
    {
        return json_encode($value, $flags, $depth);
    }
}
