<?php declare(strict_types=1);

namespace Tolkam\Utils;

use RuntimeException;

class Random
{
    /**
     * Generates random string of given length and charset type
     *
     * <code>
     *     $poolSize = 50;
     *     $stringLength = 16;
     *     $probabilityNotSeeingTheDuplicate = pow(10, -6);
     *
     *     $uniqueValuesBeforeDuplicate = 0.5+sqrt(0.25-2*pow($poolSize, $stringLength)*log(1-$probabilityNotSeeingTheDuplicate));
     * </code>
     *
     * @param int $length
     * @param string $charset
     *
     * @return string
     * @throws RuntimeException
     */
    public static function getString(int $length, string $charset = 'nice'): string
    {
        $str  = '';
        $pool = [];
    
        $lower  = 'abcdefghijklmnopqrstuvwxyz';
        $upper  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $digits = '0123456789';
        $extra = '!@#$%^&*()';
    
        switch ($charset) {
            case('numeric'):
                // 10 characters in pool
                $pool = $digits;
                break;
            case('alpha'):
                // 52 characters in pool
                $pool = $lower . $upper;
                break;
            case('alnum'):
                // 62 characters in pool
                $pool = $lower . $upper . $digits;
                break;
            case('nice'):
                // 50 characters in pool
                // without the letters that can form a 'bad' word
                $pool = 'aAbBdDeEgGhHjJkKlLmMnNoOpPqQrRvVwWxXyYzZ' . $digits;
                break;
            case('wide'):
                // 72 characters
                $pool = $extra . $lower . $upper . $digits;
                break;
            default:
                throw new RuntimeException('Unknown charset type');
        }
    
        $end = strlen($pool) - 1;
        while (strlen($str) < $length) {
            $str .= $pool[random_int(0, $end)];
        }
    
        // unique combinations = pool characters ^ length
        return $str;
    }
}
