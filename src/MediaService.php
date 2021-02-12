<?php declare(strict_types=1);

namespace Tolkam\Utils;

class MediaService
{
    /**
     * Known service ids
     */
    const YOUTUBE               = 'youtube';
    const VIMEO                 = 'vimeo';
    const INSTAGRAM             = 'instagram';
    const TWITTER               = 'twitter';
    const FACEBOOK              = 'facebook';
    const GIPHY                 = 'giphy';
    const YANDEXMAP_CONSTRUCTOR = 'yandexmapconstructor';
    const GOOGLEMAP             = 'googlemap';
    
    /**
     * Media url patterns
     *
     * @see https://github.com/cacheflowe/embetter/blob/master/README.md
     * @var array
     */
    protected static $patterns = [
        '/(?:https?:\/\/)?(?:w{3}\.)?(?:youtube\.com|youtu.be)\/(?:[\w\-]+\?v=|embed\/|v\/)?([\w\-]+)(?:\S+)?/' => self::YOUTUBE,
        '/(?:https?:\/\/)?(?:w{3}\.)?vimeo\.com\/(\S*)(?:\/?|$|\s|\?|#)/' => self::VIMEO,
        '/(?:https?:\/\/)?(?:w{3}\.)?(?:instagram\.com|instagr\.am)\/p\/([a-zA-Z0-9-_]*)(?:\/?|$|\s|\?|#)/' => self::INSTAGRAM,
        '/(?:https?:\/\/)?(?:w{3}\.)?twitter\.com\/(?:#!\/)?(?:\w+)\/status(?:es)?\/(\d+)/' => self::TWITTER,
        '/(?:https?:\/\/)?(?:w{3}\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?[\w\-]*?\/(?:[\w\-]*)?\/([\w\-]*)/' => self::FACEBOOK,
        '/(?:https?:\/\/)?(?:w{3}\.)?giphy\.com\/gifs\/(?:[\w\-]*-)?([a-zA-Z0-9]*)/' => self::GIPHY,
        '/(?:https?:\/\/)?(?:w{3}\.)?yandex\.ru\/maps\/(?:.*)?(?:\?um=|&um=)([a-z0-9:%3A]*)(?:&)*?/' => self::YANDEXMAP_CONSTRUCTOR,
        '/(?:https?:\/\/)?(?:w{3}\.)?google\.com\/maps\/embed(?:.*)?(?:\?pb=|&pb=)([a-zA-Z0-9\!\.]*)(?:&)*?/' => self::GOOGLEMAP,
    ];
    
    /**
     * Gets provider and media ids from url
     *
     * @param string $url
     *
     * @return array
     */
    public static function parseUrl(string $url): array
    {
        $ret = [
            'serviceId' => null,
            'mediaId' => null,
        ];
        
        $matches = [];
        foreach (self::$patterns as $pattern => $serviceId) {
            if (preg_match($pattern, $url, $matches)) {
                $ret['serviceId'] = $serviceId;
                $ret['mediaId'] = $matches[1] ?? null;
            }
        }
        
        return $ret;
    }
}
