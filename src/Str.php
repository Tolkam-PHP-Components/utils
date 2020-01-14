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
    
    /**
     * Converts to studly case
     *
     * @param string $value
     *
     * @return string
     */
    public static function studlyCase(string $value): string
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        
        return str_replace(' ', '', $value);
    }
    
    /**
     * Converts to camel case
     *
     * @param string $value
     *
     * @return string
     */
    public static function camelCase(string $value): string
    {
        return lcfirst(static::studlyCase($value));
    }
    
    /**
     * Converts to snake case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snakeCase(string $value, $delimiter = '_'): string
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value);
            $value = mb_strtolower($value);
        }
        
        return $value;
    }
    
    /**
     * Converts to kebab case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function kebabCase(string $value, $delimiter = '-')
    {
        return static::snakeCase($value, $delimiter);
    }
    
    /**
     * Removes duplicate path segment separators
     *
     * @param string $uri
     * @param string $separator
     *
     * @return string
     */
    public static function fixPathSeparators(string $uri, string $separator): string
    {
        // replace multiple separator occurrences with
        // single one preserving protocol slashes (://)
        return preg_replace(
            '~(?<=[^:\s])(' . $separator . '+' . $separator . ')~',
            $separator,
            $uri
        );
    }
}
