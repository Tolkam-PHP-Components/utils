<?php declare(strict_types=1);

namespace Tolkam\Utils;

use ArrayAccess;

/**
 * Partial version of \Illuminate\Support\Arr
 *
 * @package Tolkam\Utils
 */
class Arr
{
    /**
     * Checks if given value is array accessible
     *
     * @param $value
     *
     * @return bool
     */
    public static function accessible($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }
    
    /**
     * Checks if given key exists in the array
     *
     * @param mixed  $array
     * @param string $key
     *
     * @return bool
     */
    public static function exists($array, string $key)
    {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }
        
        return array_key_exists($key, $array);
    }
    
    /**
     * Gets an item from an array using path notation
     *
     * @param array|ArrayAccess $array
     * @param string|null       $key
     * @param mixed             $default
     * @param string            $sep
     *
     * @return mixed
     */
    public static function get($array, string $key = null, $default = null, string $sep = '.')
    {
        if (!static::accessible($array)) {
            return $default;
        }
        
        if ($key === null) {
            return $array;
        }
        
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        
        if (mb_strpos($key, $sep) === false) {
            return $array[$key] ?? $default;
        }
        
        foreach (explode($sep, $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        
        return $array;
    }
    
    /**
     * Sets an array item to a given value using path notation
     *
     * @param array|ArrayAccess $array
     * @param string            $key
     * @param mixed             $value
     * @param string            $sep
     *
     * @return array
     */
    public static function set(&$array, string $key, $value, string $sep = '.')
    {
        $keys = explode($sep, $key);
        
        while (count($keys) > 1) {
            $key = array_shift($keys);
            
            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (!isset($array[$key]) || !static::accessible($array[$key])) {
                $array[$key] = [];
            }
            
            $array = &$array[$key];
        }
        
        $array[array_shift($keys)] = $value;
        
        return $array;
    }
    
    /**
     * Adds an element to an array using path notation if it doesn't exist
     *
     * @param        $array
     * @param string $key
     * @param        $value
     *
     * @param string $sep
     *
     * @return array
     */
    public static function add(&$array, string $key, $value, string $sep = '.')
    {
        if (static::get($array, $key, null, $sep) === null) {
            static::set($array, $key, $value, $sep);
        }
        
        return $array;
    }
    
    /**
     * Flattens a multi-dimensional associative array with separator
     *
     * @param  array  $array
     * @param  string $prefix
     * @param string  $sep
     *
     * @return array
     */
    public static function flattenSeparator(array $array, string $prefix = '', string $sep = '.')
    {
        $results = [];
        
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::flattenSeparator($value, $prefix . $key . $sep));
            } else {
                $results[$prefix . $key] = $value;
            }
        }
        
        return $results;
    }
}
