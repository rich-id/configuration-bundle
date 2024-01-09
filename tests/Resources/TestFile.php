<?php

declare(strict_types=1);

namespace RichId\ConfigurationBundle\Tests\Resources;

class TestFile
{
    public const FILES_DIRECTORY = __DIR__ . '/Files';
    public const PROJECT_DIRECTORY = __DIR__ . '/../..';

    public static function getFilePath(string $relativePath): string
    {
        $rootFolder = str_starts_with($relativePath, '/') ? static::PROJECT_DIRECTORY : static::FILES_DIRECTORY;
        $path = \sprintf('%s/%s', $rootFolder, $relativePath);

        return \realpath($path) ?: $path;
    }

    public static function delete(string $path, bool $absolutePath = false): bool
    {
        $path = $absolutePath ? $path : static::getFilePath($path);

        if (!\file_exists($path)) {
            return true;
        }

        if (!\is_dir($path)) {
            return \unlink($path);
        }

        foreach (\scandir($path) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            if (!static::delete($path . DIRECTORY_SEPARATOR . $item, true)) {
                return false;
            }
        }

        return \rmdir($path);
    }
}
