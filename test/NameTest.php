<?php
declare(strict_types=1);

use Loilo\StoragePaths\StoragePaths;
use PHPUnit\Framework\TestCase;
use Loilo\StoragePaths\StoragePathsInterface;

final class NameTest extends TestCase
{
    public function testCanBeCreatedWithValidNameOnMacOS(): void
    {
        $this->assertInstanceOf(
            StoragePathsInterface::class,
            StoragePaths::for('test:app', [
                'os' => 'Darwin'
            ])
        );
    }

    public function testCannotBeCreatedWithInvalidNameOnMacOS(): void
    {
        $this->expectException(InvalidArgumentException::class);

        StoragePaths::for('test/app', [
            'os' => 'Darwin'
        ]);
    }

    public function testCanBeCreatedWithValidNameOnLinux(): void
    {
        $this->assertInstanceOf(
            StoragePathsInterface::class,
            StoragePaths::for('test:app', [
                'os' => 'Linux'
            ])
        );
    }

    public function testCannotBeCreatedWithInvalidNameOnLinux(): void
    {
        $this->expectException(InvalidArgumentException::class);

        StoragePaths::for('test/app', [
            'os' => 'Linux'
        ]);
    }

    public function testCanBeCreatedWithValidNameOnWindows(): void
    {
        $this->assertInstanceOf(
            StoragePathsInterface::class,
            StoragePaths::for('test_app', [
                'os' => 'Windows'
            ])
        );
    }

    public function testCannotBeCreatedWithInvalidNameOnWindows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        StoragePaths::for('test:app', [
            'os' => 'Windows'
        ]);
    }
}
