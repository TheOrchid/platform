<?php

namespace Orchid\Platform\Configuration;

use Composer\InstalledVersions;

trait ManagesPackage
{
    protected static string $composerPackage = 'orchid/platform';

    /**
     * Get the version number of the application.
     */
    public static function version(): string
    {
        return InstalledVersions::getVersion(static::$composerPackage);
    }

    /**
     * The real path to the package files.
     */
    public static function path(string $path = ''): string
    {
        $current = InstalledVersions::getInstallPath(static::$composerPackage);

        return realpath($current.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}
