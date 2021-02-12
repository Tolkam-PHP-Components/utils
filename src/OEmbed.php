<?php declare(strict_types=1);

namespace Tolkam\Utils;

/**
 * @deprecated Use MediaService instead
 */
class OEmbed
{
    /**
     * Known providers ids
     */
    const PROVIDER_YOUTUBE               = 'youtube';
    const PROVIDER_VIMEO                 = 'vimeo';
    const PROVIDER_INSTAGRAM             = 'instagram';
    const PROVIDER_TWITTER               = 'twitter';
    const PROVIDER_FACEBOOK              = 'facebook';
    const PROVIDER_GIPHY                 = 'giphy';
    const PROVIDER_YANDEXMAP_CONSTRUCTOR = 'yandexmapconstructor';
    const PROVIDER_GOOGLEMAP             = 'googlemap';
    
    /**
     * Media url patterns to provider id map
     * @see https://github.com/cacheflowe/embetter/blob/master/README.md
     * @var array
     */
    protected static $patterns = [
        // '/(?:.+?)?(?:youtube\.com\/v\/|watch\/|\?v=|\&v=|youtu\.be\/|\/v=|^youtu\.be\/)([a-zA-Z0-9_-]{11})+/'           => self::PROVIDER_YOUTUBE,
        '/(?:https?:\/\/)?(?:w{3}\.)?(?:youtube\.com|youtu.be)\/(?:[\w\-]+\?v=|embed\/|v\/)?([\w\-]+)(?:\S+)?/' => self::PROVIDER_YOUTUBE,
        '/(?:https?:\/\/)?(?:w{3}\.)?vimeo\.com\/(\S*)(?:\/?|$|\s|\?|#)/' => self::PROVIDER_VIMEO,
        '/(?:https?:\/\/)?(?:w{3}\.)?(?:instagram\.com|instagr\.am)\/p\/([a-zA-Z0-9-_]*)(?:\/?|$|\s|\?|#)/' => self::PROVIDER_INSTAGRAM,
        '/(?:https?:\/\/)?(?:w{3}\.)?twitter\.com\/(?:#!\/)?(?:\w+)\/status(?:es)?\/(\d+)/' => self::PROVIDER_TWITTER,
        '/(?:https?:\/\/)?(?:w{3}\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?[\w\-]*?\/(?:[\w\-]*)?\/([\w\-]*)/' => self::PROVIDER_FACEBOOK,
        '/(?:https?:\/\/)?(?:w{3}\.)?giphy\.com\/gifs\/(?:[\w\-]*-)?([a-zA-Z0-9]*)/' => self::PROVIDER_GIPHY,
        '/(?:https?:\/\/)?(?:w{3}\.)?yandex\.ru\/maps\/(?:.*)?(?:\?um=|&um=)([a-z0-9:%3A]*)(?:&)*?/' => self::PROVIDER_YANDEXMAP_CONSTRUCTOR,
        '/(?:https?:\/\/)?(?:w{3}\.)?google\.com\/maps\/embed(?:.*)?(?:\?pb=|&pb=)([a-zA-Z0-9\!\.]*)(?:&)*?/' => self::PROVIDER_GOOGLEMAP,
    ];
    
    /**
     * Gets provider and media ids from url
     *
     * @param string $url
     *
     * @return array|null
     */
    public static function parseUrl(string $url)
    {
        $matches = [];
        foreach (self::$patterns as $pattern => $providerId) {
            if (preg_match($pattern, $url, $matches)) {
                return [
                    'providerId' => $providerId,
                    'mediaId' => $matches[1] ?? null,
                ];
            }
        }
        
        return null;
    }
}
