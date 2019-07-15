<?php
declare(strict_types=1);

use Loilo\StoragePaths\LinuxStoragePaths;
use Loilo\StoragePaths\MacOSStoragePaths;
use Loilo\StoragePaths\StoragePathsInterface;
use Loilo\StoragePaths\StoragePaths;
use Loilo\StoragePaths\WindowsStoragePaths;
use PHPUnit\Framework\TestCase;

final class CreationTest extends TestCase
{
    public function testCreatesStoragePathInterface(): void
    {
        $this->assertInstanceOf(
            StoragePathsInterface::class,
            StoragePaths::for('test-app')
        );
    }

    public function testInfersOsSpecificClass(): void
    {
        switch (PHP_OS_FAMILY) {
            case 'Darwin':
                $class = MacOSStoragePaths::class;
                break;

            case 'Windows':
                $class = WindowsStoragePaths::class;
                break;

            default:
                $class = LinuxStoragePaths::class;
        }

        $this->assertInstanceOf(
            $class,
            StoragePaths::for('test-app')
        );
    }

    public function testObeysCustomOs(): void
    {
        $this->assertInstanceOf(
            MacOSStoragePaths::class,
            StoragePaths::for('test-app', [ 'os' => 'Darwin' ])
        );

        $this->assertInstanceOf(
            WindowsStoragePaths::class,
            StoragePaths::for('test-app', [ 'os' => 'Windows' ])
        );

        $this->assertInstanceOf(
            LinuxStoragePaths::class,
            StoragePaths::for('test-app', [ 'os' => 'Linux' ])
        );

        $this->assertInstanceOf(
            LinuxStoragePaths::class,
            StoragePaths::for('test-app', [ 'os' => 'test-os' ])
        );
    }
}
