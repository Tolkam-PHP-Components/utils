<?php declare(strict_types=1);

namespace Tolkam\Utils;

use FilesystemIterator;
use RuntimeException;
use Traversable;
use function is_array;
use const DIRECTORY_SEPARATOR;

class Filesystem
{
    /**
     * Checks if running under Windows
     *
     * @return bool
     */
    public static function isWindows(): bool
    {
        return '\\' === DIRECTORY_SEPARATOR;
    }
    
    /**
     * Deletes files or directories recursively
     *
     * @param Traversable|string[]|string $files
     */
    public static function remove($files): void
    {
        if ($files instanceof Traversable) {
            $files = iterator_to_array($files, false);
        } elseif (!is_array($files)) {
            $files = [$files];
        }
        $files = array_reverse($files);
        
        foreach ($files as $file) {
            // link
            if (is_link($file)) {
                // See https://bugs.php.net/52176
                if (!(unlink($file) || !self::isWindows() || rmdir($file)) && file_exists($file)) {
                    throw new RuntimeException(sprintf('Failed to remove symlink "%s".', $file));
                }
            } // dir
            elseif (is_dir($file)) {
                self::remove(new FilesystemIterator(
                    $file,
                    FilesystemIterator::CURRENT_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
                ));
                
                if (!rmdir($file) && file_exists($file)) {
                    throw new RuntimeException(sprintf('Failed to remove directory "%s".', $file));
                }
            } // file
            elseif (!unlink($file) && file_exists($file)) {
                throw new RuntimeException(sprintf('Failed to remove file "%s".', $file));
            }
        }
    }
}
