<?php namespace Loilo\StoragePaths;

/**
 * Get data storing paths for a certain OS environment
 */
interface StoragePathsInterface
{
    /**
     * Get directory for data files
     *
     * @return string
     */
    public function data(): string;

    /**
     * Get directory for config files
     *
     * @return string
     */
    public function config(): string;

    /**
     * Get directory for non-essential data files
     *
     * @return string
     */
    public function cache(): string;

    /**
     * Get directory for log files
     *
     * @return string
     */
    public function log(): string;

    /**
     * Get directory for temporary files
     *
     * @return string
     */
    public function temp(): string;
}
