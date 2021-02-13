<?php declare(strict_types=1);

namespace Tolkam\Utils;

class Html
{
    /**
     * Builds class names string from supplied values
     *
     * @see https://github.com/JedWatson/classnames
     *
     * @param mixed ...$args
     *
     * @return string
     */
    public static function classNames(...$args): string
    {
        $classNames = [];
        
        foreach ($args as $arg) {
            if (is_string($arg) && !!$arg) {
                $classNames[] = $arg;
            }
            elseif (is_array($arg)) {
                $classNames = array_merge(
                    $classNames,
                    array_keys(array_filter($arg))
                );
            }
        }
        
        return implode(' ', $classNames);
    }
}
