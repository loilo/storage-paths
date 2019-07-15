<?php namespace Loilo\StoragePaths;

use InvalidArgumentException;

/**
 * Get data storing paths for your operating system
 */
class StoragePaths
{
    /**
     * Get paths for storing things like data, config, cache, etc.
     *
     * @param string $name   The name of the project to generate paths for
     * @param array $options An array of options
     * @return StoragePathsInterface
     */
    public static function for(string $name, array $options = []): StoragePathsInterface
    {
        if (empty($name)) {
            throw new InvalidArgumentException('A storage-paths name cannot be empty');
        }

        if (defined('PHP_OS_FAMILY')) {
            $defaultOS = PHP_OS_FAMILY;
        } else {
            if (DIRECTORY_SEPARATOR === '\\') {
                $defaultOS = 'Windows';
            } elseif (PHP_OS === 'OSX' || PHP_OS === 'Darwin') {
                $defaultOS = 'Darwin';
            } else {
                $defaultOS = 'Linux';
            }
        }

        $options = array_merge([
            'suffix' => 'php',
            'os' => $defaultOS
        ], $options);

        if (is_string($options['suffix']) && strlen($options['suffix']) > 0) {
            $name .= '-' . $options['suffix'];
        }

        switch ($options['os']) {
            case 'Darwin':
                return new MacOSStoragePaths($name);
            
            case 'Windows':
                return new WindowsStoragePaths($name);
            
            default:
                return new LinuxStoragePaths($name);
        }
    }
}
