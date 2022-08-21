<?php

namespace Parser\Services;

class StringService
{
    /**
     * Make a string lowercase
     * @param string $string
     * @return string
     */
    public function strToLower(string $string): string
    {
        return strtolower($string);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return false|int
     */
    public function strPos(string $haystack, string $needle, int $offset = 0)
    {
        return strpos($haystack, $needle, $offset);
    }

    /**
     * @param string $string
     * @return string
     */
    public function uppercaseFirst(string $string): string
    {
        return ucfirst($string);
    }
}
