<?php
declare(strict_types=1);

namespace Loilo\StoragePaths\Test;

use Loilo\StoragePaths\StoragePaths;
use PHPUnit\Framework\TestCase;

final class LinuxTest extends TestCase
{
    protected function setUp(): void
    {
        if (PHP_OS === 'Darwin' || PHP_OS === 'OSX' || DIRECTORY_SEPARATOR === '\\') {
            $this->markTestSkipped();
        }
    }

    public function testCorrectPathsWithXDG(): void
    {
        $envVars = [
          'data' => 'XDG_DATA_HOME',
          'config' => 'XDG_CONFIG_HOME',
          'cache' => 'XDG_CACHE_HOME',
          'log' => 'XDG_STATE_HOME'
        ];

        foreach ($envVars as $env) {
            putenv("$env=/tmp/$env");
        }

        $paths = StoragePaths::for('test-app');
        
        foreach ($envVars as $var => $env) {
            $expectedPath = getenv($env);
            $path = $paths->$var();

            $this->assertStringStartsWith($expectedPath, $path);
            $this->assertStringEndsWith('test-app-php', $path);
        }
    }
}
