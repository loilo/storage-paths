<div align="center">
  <img alt="Storage Paths logo: a file cabinet with an open drawer which contains printed document" src="storage-paths.svg" width="196" height="196">
</div>

# Storage Paths
[![Test status on Travis](https://badgen.net/travis/loilo/storage-paths?label=tests&icon=travis)](https://travis-ci.org/loilo/storage-paths)
[![Version on packagist.org](https://badgen.net/packagist/v/loilo/storage-paths)](https://packagist.org/packages/loilo/storage-paths)

This package yields OS-specific paths for storing your project's config, cache, logs etc. While the API has been adjusted for PHP, the research and opinionated fallbacks stem from the Node.js [env-paths](https://github.com/sindresorhus/env-paths) package by [Sindre Sorhus](https://github.com/sindresorhus).

## Install
```bash
composer require loilo/storage-paths
```

## Usage
Example for macOS:

```php
use Loilo\StoragePaths\StoragePaths;

$paths = StoragePaths::for('MyApp');

$paths->data()   === '/Users/loilo/Library/Application Support/MyApp-php';
$paths->config() === '/Users/loilo/Library/Preferences/MyApp-php';
$paths->cache()  === '/Users/loilo/Library/Caches/MyApp-php';
$paths->log()    === '/Users/loilo/Library/Logs/MyApp-php';
$paths->temp()   === '/var/folders/qh/z_hny67s57sfm_sxy1zynnkr0000gn/T/MyApp-php';
```

## API
### Signature
```php
StoragePaths::for(string $name, array $options): StoragePathsInterface;
```

* `$name` — The name of your project. This is used to generate the paths, therefore it needs to be a valid filename.

* `$options` — An (optional) associative array of options:
  * `$options['suffix']`

    **Type:** `string`

    **Default:** `'php'`
    
    A suffix string appended to the project name to avoid naming conflicts with native apps.
  * `$options['os']`

    **Type:** `string`

    **Default:** `PHP_OS_FAMILY`
    
    Override the operating system to generate paths for. Values correspond to the [`PHP_OS_FAMILY`](https://www.php.net/manual/reserved.constants.php#constant.php-os-family) constant.

> **Note:** Calling `StoragePaths::for()` only generates the path strings. It doesn't create the directories for you.

### Result
The returned [`StoragePathsInterface`](src/StoragePathsInterface.php) provides access to the following storage methods:

* `data()` — Directory for data files
* `config()` — Directory for config files
* `cache()` — Directory for for non-essential data files
* `log()` — Directory for log files
* `temp()` — Directory for temporary files
