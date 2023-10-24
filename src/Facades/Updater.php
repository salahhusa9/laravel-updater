<?php

namespace Salahhusa9\Updater\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Salahhusa9\Updater\Updater
 *
 * @method static string update() Update the application to the latest version
 * @method static array newVersionAvailable() Check if a new version is available
 * @method static string getLatestVersion() Get the latest version
 * @method static string getCurrentVersion() Get the current version
 * @method static string getLatestVersionData() Get the latest version data
 * @method static string versions() Get all versions
 */
class Updater extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Salahhusa9\Updater\Updater::class;
    }
}
