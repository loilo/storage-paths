<?php namespace Loilo\StoragePaths;

use InvalidArgumentException;
use Webmozart\PathUtil\Path;

/**
 * Get data storing paths for macOS
 */
class MacOSStoragePaths implements StoragePathsInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $library;

    public function __construct(string $name)
    {
        if (strpos($name, '/') !== false) {
            throw new InvalidArgumentException(sprintf(
                'Invalid storage-paths name: "%s" is not a valid macOS file name',
                $name
            ));
        }

        $this->name = $name;
        $this->library = Path::join(Path::getHomeDirectory(), 'Library');
    }

    /**
     * {@inheritdoc}
     */
    public function data(): string
    {
        return Path::join($this->library, 'Application Support', $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function config(): string
    {
        return Path::join($this->library, 'Preferences', $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function cache(): string
    {
        return Path::join($this->library, 'Caches', $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function log(): string
    {
        return Path::join($this->library, 'Logs', $this->name);
    }

    /**
     * {@inheritdoc}
     */
    public function temp(): string
    {
        return Path::join(sys_get_temp_dir(), $this->name);
    }
}
