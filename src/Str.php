<?php declare(strict_types=1);

namespace Tolkam\Utils;

class Str
{
    /**
     * Checks if character is between two other characters in utf-8 tables
     *
     * @param string      $char
     * @param string|null $charStart
     * @param string|null $charEnd
     *
     * @return bool
     */
    public static function charIsBetween(string $char, string $charStart = null, string $charEnd = null): bool
    {
        $enc = 'utf-8';
    
        $char = $char ? mb_ord($char, $enc) : 0;
        $charStart = $charStart ? mb_ord($charStart, $enc) : 0;
        $charEnd = $charEnd ? mb_ord($charEnd, $enc) : PHP_INT_MAX;
        
        return  $charStart <= $char && $char <= $charEnd;
    }
}
