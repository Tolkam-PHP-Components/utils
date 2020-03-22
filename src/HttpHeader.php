<?php declare(strict_types=1);

namespace Tolkam\Utils;

class HttpHeader
{
    /**
     * Checks if accept header string matches the content type
     *
     * @param string $acceptStr
     * @param array  $contentTypes
     *
     * @return bool
     */
    public static function isAccepted(string $acceptStr, array $contentTypes): bool
    {
        $sortedAccept = self::parseAccept($acceptStr);
        
        foreach ($sortedAccept as $item) {
            if (in_array($item['mime'], $contentTypes)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Parses and sorts accept header string
     *
     * @param string $acceptStr
     * @param bool   $sortByWeight
     *
     * @return array
     */
    public static function parseAccept(string $acceptStr, bool $sortByWeight = true): array
    {
        $weightParam = 'q=';
        $values = array_map('strtolower', explode(',', $acceptStr));
        $result = [];
        
        foreach ($values as $raw) {
            [$mime, $extension] = explode(';', $raw) + ['', ''];
            [$type, $subtype] = explode('/', $mime) + ['', ''];
            
            $weight = 1.0;
            if (preg_match('~^' . $weightParam . '~', $extension)) {
                $weight = (float) str_replace($weightParam, '', $extension);
            }
            
            $result[] = [
                'mime' => $mime,
                'type' => $type,
                'subtype' => $subtype,
                'weight' => $weight,
            ];
        }
        
        if ($sortByWeight) {
            usort($result, fn($a, $b) => $b['weight'] <=> $a['weight']);
        }
        
        return $result;
    }
}
