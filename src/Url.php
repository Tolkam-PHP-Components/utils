<?php declare(strict_types=1);

namespace Tolkam\Utils;

use const PHP_URL_SCHEME;

class Url
{
    /**
     * Parses url into array
     *
     * Output is same as parse_url() except query is parsed into array too
     *
     * @param string $url
     *
     * @return array
     */
    public static function parse(string $url): array
    {
        $parsed = parse_url($url);
        parse_str($parsed['query'] ?? '', $parsed['query']);
        
        return $parsed;
    }
    
    /**
     * Builds url string from array in self::parse() output format
     *
     * @param array  $parsed
     *
     * @param string $querySep
     * @param string $argSep
     *
     * @return string
     */
    public static function build(
        array $parsed,
        string $querySep = '?',
        string $argSep = '&'
    ): string {
        $str = '';
        if ($scheme = $parsed['scheme'] ?? '') {
            $str .= $scheme . '://';
        }
        
        if ($user = $parsed['user'] ?? '') {
            $pass = $parsed['pass'] ?? '';
            $str .= $user;
            $str .= $pass ? ':' . $pass : $pass;
            $str .= '@';
        }
        
        if ($host = $parsed['host'] ?? '') {
            $str .= $host;
        }
        
        if ($port = $parsed['port'] ?? '') {
            $str .= ':' . $port;
        }
        
        if ($path = $parsed['path'] ?? '') {
            $str .= $path;
        }
        
        if ($query = http_build_query($parsed['query'] ?? '', '', $argSep, PHP_QUERY_RFC3986)) {
            $str .= $querySep . rawurldecode($query);
        }
        
        if ($fragment = $parsed['fragment'] ?? '') {
            $str .= '#' . $fragment;
        }
        
        return $str;
    }
    
    /**
     * Makes url absolute
     *
     * This method does not checks for url validity
     *
     * @param string $url
     * @param string $authority
     * @param string $scheme
     *
     * @return string
     */
    public static function toAbsolute(
        string $url,
        string $authority,
        string $scheme = ''
    ): string {
        if (static::isAbsolute($url)) {
            return $url;
        }
        
        $sep = '/';
        $scheme .= $scheme ? ':' : '';
        
        return rtrim(Str::fixPathSeparators(
            $scheme . '//' . $authority . $sep . $url, $sep
        ), $sep);
    }
    
    /**
     * Checks if url is absolute
     *
     * This method does not checks for url validity
     *
     * @param string $url
     *
     * @return bool
     */
    public static function isAbsolute(string $url): bool
    {
        // starts with double slash
        if (strlen($url) > 2 && substr($url, 0, 2) === '//' && $url[2] !== '/') {
            return true;
        }
        
        return is_string(parse_url($url, PHP_URL_SCHEME));
    }
}
