<?php declare(strict_types=1);

namespace Tolkam\Utils;

class I18n
{
    /**
     * Gets plural form index from locale and count
     *
     * The plural rules are derived from code of the Zend Framework (2010-09-25),
     * which is subject to the new BSD license
     * (http://framework.zend.com/license/new-bsd).
     * Copyright (c) 2005-2010 Zend Technologies USA Inc.
     * (http://www.zend.com)
     * https://github.com/zendframework/zf1/blob/master/library/Zend/Translate/Plural.php
     *
     * @param string $locale language code
     * @param int    $count  plural variable
     *
     * @return integer index of plural form rule.
     */
    public static function pluralIndex(string $locale, int $count)
    {
        switch ($locale) {
            case 'af':
            case 'bn':
            case 'bg':
            case 'ca':
            case 'da':
            case 'de':
            case 'el':
            case 'en':
            case 'eo':
            case 'es':
            case 'et':
            case 'eu':
            case 'fa':
            case 'fi':
            case 'fo':
            case 'fur':
            case 'fy':
            case 'gl':
            case 'gu':
            case 'ha':
            case 'he':
            case 'hu':
            case 'is':
            case 'it':
            case 'ku':
            case 'lb':
            case 'ml':
            case 'mn':
            case 'mr':
            case 'nah':
            case 'nb':
            case 'ne':
            case 'nl':
            case 'nn':
            case 'no':
            case 'om':
            case 'or':
            case 'pa':
            case 'pap':
            case 'ps':
            case 'pt':
            case 'so':
            case 'sq':
            case 'sv':
            case 'sw':
            case 'ta':
            case 'te':
            case 'tk':
            case 'ur':
            case 'zu':
                $index = ($count === 1) ? 0 : 1;
                break;
            
            case 'am':
            case 'bh':
            case 'fil':
            case 'fr':
            case 'gun':
            case 'hi':
            case 'ln':
            case 'mg':
            case 'nso':
            case 'xbr':
            case 'ti':
            case 'wa':
                $index = (($count === 0) || ($count === 1)) ? 0 : 1;
                break;
            
            case 'be':
            case 'bs':
            case 'hr':
            case 'ru':
            case 'sr':
            case 'uk':
                $index = (($count % 10 === 1) && ($count % 100 != 11))
                    ? (0)
                    : ((($count % 10 >= 2) && ($count % 10 <= 4) && (($count % 100 < 10) || ($count % 100 >= 20)))
                        ? 1
                        : 2
                    );
                break;
            
            case 'cs':
            case 'sk':
                $index = ($count === 1) ? 0 : ((($count >= 2) && ($count <= 4)) ? 1 : 2);
                break;
            
            case 'ga':
                $index = ($count === 1) ? 0 : (($count === 2) ? 1 : 2);
                break;
            
            case 'lt':
                $index = (($count % 10 === 1) && ($count % 100 != 11))
                    ? (0)
                    : ((($count % 10 >= 2) && (($count % 100 < 10) || ($count % 100 >= 20)))
                        ? 1
                        : 2
                    );
                break;
            
            case 'sl':
                $index = ($count % 100 === 1)
                    ? (0)
                    : (($count % 100 === 2)
                        ? 1
                        : ((($count % 100 === 3) || ($count % 100 === 4))
                            ? 2
                            : 3
                        ));
                break;
            
            case 'mk':
                $index = ($count % 10 === 1) ? 0 : 1;
                break;
            
            case 'mt':
                $index = ($count === 1)
                    ? (0)
                    : ((($count === 0) || (($count % 100 > 1) && ($count % 100 < 11)))
                        ? (1)
                        : ((($count % 100 > 10) && ($count % 100 < 20))
                            ? 2
                            : 3
                        ));
                break;
            
            case 'lv':
                $index = ($count === 0) ? 0 : ((($count % 10 === 1) && ($count % 100 != 11)) ? 1 : 2);
                break;
            
            case 'pl':
                $index = ($count === 1)
                    ? (0)
                    : ((($count % 10 >= 2) && ($count % 10 <= 4) && (($count % 100 < 12) || ($count % 100 > 14)))
                        ? 1
                        : 2
                    );
                break;
            
            case 'cy':
                $index = ($count === 1)
                    ? (0)
                    : (($count === 2) ? 1 : ((($count === 8) || ($count === 11))
                        ? 2
                        : 3
                    ));
                break;
            
            case 'ro':
                $index = ($count === 1)
                    ? (0)
                    : ((($count === 0) || (($count % 100 > 0) && ($count % 100 < 20)))
                        ? 1
                        : 2
                    );
                break;
            
            case 'ar':
                $index = ($count === 0)
                    ? (0)
                    : (($count === 1)
                        ? 1
                        : (($count === 2)
                            ? 2
                            : ((($count >= 3) && ($count <= 10))
                                ? (3)
                                : ((($count >= 11) && ($count <= 99))
                                    ? 4
                                    : 5
                                ))));
                break;
            
            case 'az':
            case 'bo':
            case 'dz':
            case 'id':
            case 'ja':
            case 'jv':
            case 'ka':
            case 'km':
            case 'kn':
            case 'ko':
            case 'ms':
            case 'th':
            case 'tr':
            case 'vi':
            case 'zh':
            default:
                $index = 0;
                break;
        }
        
        return $index;
    }
}
