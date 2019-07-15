<?php
declare(strict_types=1);

use Loilo\StoragePaths\StoragePaths;
use PHPUnit\Framework\TestCase;
use Loilo\StoragePaths\StoragePathsInterface;

final class SuffixTest extends TestCase
{
    public function testCustomSuffix(): void
    {
        $paths = StoragePaths::for('test-app', [ 'suffix' => 'x' ]);

        $this->assertStringEndsWith('test-app-x', $paths->data());
        $this->assertStringEndsWith('test-app-x', $paths->config());
        $this->assertStringEndsWith('test-app-x', $paths->cache());
        $this->assertStringEndsWith('test-app-x', $paths->log());
        $this->assertStringEndsWith('test-app-x', $paths->temp());
    }

    public function testEmptyCustomSuffix(): void
    {
        $paths = StoragePaths::for('test-app', [ 'suffix' => '' ]);

        $this->assertStringEndsWith('test-app', $paths->data());
        $this->assertStringEndsWith('test-app', $paths->config());
        $this->assertStringEndsWith('test-app', $paths->cache());
        $this->assertStringEndsWith('test-app', $paths->log());
        $this->assertStringEndsWith('test-app', $paths->temp());
    }
}
