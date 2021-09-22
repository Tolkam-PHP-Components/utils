<?php declare(strict_types=1);

namespace Tolkam\Utils;

class SVG
{
    /**
     * Scales svg path to fit coordinates between 0 and 1
     *
     * @param int    $width
     * @param int    $height
     * @param string $path
     * @param int    $precision
     *
     * @return string
     */
    public static function scalePathToRelative(
        int $width,
        int $height,
        string $path,
        int $precision = 3
    ): string {
        
        $pattern = '~\d+(\.\d+)?~';
        $i = 0;
        $callback = function (array $matches) use (&$i, $width, $height, $precision) {
            $delim = $i % 2 ? $height : $width;
            $i++;
            
            return round($matches[0] / max($delim, 1), $precision, PHP_ROUND_HALF_DOWN);
        };
        
        return preg_replace_callback($pattern, $callback, $path);
    }
}
