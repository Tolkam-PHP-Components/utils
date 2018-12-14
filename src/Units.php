<?php declare(strict_types=1);

namespace Tolkam\Utils;

class Units
{
    /**
     * Gets human readable duration
     *
     * @param float $seconds
     *
     * @return array
     */
    public static function readableSeconds(float $seconds): array
    {
        $map = [
            'h' => 60*60,
            'm' => 60,
            's' => 1,
            'ms' => 1 / 1e3,
            'u' => 1 / 1e6
        ];

        $out = [];

        foreach ($map as $k => $v) {
            $out[$k] = floor($seconds / $v);
            $seconds = fmod($seconds, $v);
        }

        return $out;
    }

    /**
     * Gets human readable size
     *
     * @param float $bytes
     *
     * @return array
     */
    public static function readableBytes(float $bytes): array
    {
        $i = (int) floor(log($bytes, 1024));

        // unit => precision
        $map = [
        'B'  => 0,
        'kB' => 0,
        'MB' => 2,
        'GB' => 2,
        'TB' => 3,
        'PB' => 3,
        'EB' => 4,
        'ZB' => 4,
        'YB' => 5,
        ];

        return [
            'value' => round($bytes / pow(1024, $i), array_values($map)[$i]),
            'unit' => array_keys($map)[$i],
        ];
    }
}
