<?php namespace Loilo\StoragePaths;

use InvalidArgumentException;
use Webmozart\PathUtil\Path;

/**
 * Get data storing paths for Linux
 * @see https://specifications.freedesktop.org/basedir-spec/basedir-spec-latest.html
 */
class LinuxStoragePaths implements StoragePathsInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $homeDirectory;

    /**
     * @var string
     */
    protected $username;

    public function __construct(string $name)
    {
        if (strpos($name, '/') !== false) {
            throw new InvalidArgumentException(sprintf(
                'Invalid storage-paths name: "%s" is not a valid Linux file name',
                $name
            ));
        }

        $this->name = $name;
        $this->homeDirectory = Path::getHomeDirectory();
        $this->username = Path::getFilename($this->homeDirectory);
    }

    /**
     * {@inheritdoc}
     */
    public function data(): string
    {
        return Path::join(
            getenv('XDG_DATA_HOME') ?: Path::join($this->homeDirectory, '.local', 'share'),
            $this->name
        );
    }

    /**
     * {@inheritdoc}
     */
    public function config(): string
    {
        return Path::join(
            getenv('XDG_CONFIG_HOME') ?: Path::join($this->homeDirectory, '.config'),
            $this->name
        );
    }

    /**
     * {@inheritdoc}
     */
    public function cache(): string
    {
        return Path::join(
            getenv('XDG_CACHE_HOME') ?: Path::join($this->homeDirectory, '.cache'),
            $this->name
        );
    }

    /**
     * {@inheritdoc}
     * @see https://wiki.debian.org/XDGBaseDirectorySpecification#state
     */
    public function log(): string
    {
        return Path::join(
            getenv('XDG_STATE_HOME') ?: Path::join($this->homeDirectory, '.local', 'state'),
            $this->name
        );
    }

    /**
     * {@inheritdoc}
     */
    public function temp(): string
    {
        return Path::join(sys_get_temp_dir(), $this->username, $this->name);
    }
}
