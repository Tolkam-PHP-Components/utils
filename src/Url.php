<?php declare(strict_types=1);

namespace Tolkam\Utils;

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
    public static function parse(string $url)
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
    public static function build(array $parsed, string $querySep = '?', string $argSep = '&')
    {
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
}
