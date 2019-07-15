<?php namespace Loilo\StoragePaths;

use InvalidArgumentException;
use Webmozart\PathUtil\Path;

/**
 * Get data storing paths for Windows
 * Paths for data/config/cache/log were invented by Sindre Sorhus as Windows isn't opinionated about this
 */
class WindowsStoragePaths implements StoragePathsInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $appData;

    /**
     * @var string
     */
    protected $localAppData;

    public function __construct(string $name)
    {
        // @see https://docs.microsoft.com/de-de/windows/win32/fileio/naming-a-file#naming_conventions
        if (preg_match('/^(con|prn|aux|nul|com[0-9]|lpt[0-9])$/i', $name) ||
            preg_match('@[<>:"/\\\\|?*\x{00}-\x{1F}]@', $name)
        ) {
            throw new InvalidArgumentException(sprintf(
                'Invalid storage-paths name: "%s" is not a valid Windows file name',
                $name
            ));
        }

        $this->name = $name;

        $home = Path::getHomeDirectory();
        $this->appData = getenv('APPDATA') ?: Path::join($home, 'Appdata', 'Roaming');
        $this->localAppData = getenv('LOCALAPPDATA') ?: Path::join($home, 'Appdata', 'Local');
    }

    /**
     * {@inheritdoc}
     */
    public function data(): string
    {
        return Path::join($this->localAppData, $this->name, 'Data');
    }

    /**
     * {@inheritdoc}
     */
    public function config(): string
    {
        return Path::join($this->appData, $this->name, 'Config');
    }

    /**
     * {@inheritdoc}
     */
    public function cache(): string
    {
        return Path::join($this->localAppData, $this->name, 'Cache');
    }

    /**
     * {@inheritdoc}
     */
    public function log(): string
    {
        return Path::join($this->localAppData, $this->name, 'Log');
    }

    /**
     * {@inheritdoc}
     */
    public function temp(): string
    {
        return Path::join(sys_get_temp_dir(), $this->name);
    }
}
