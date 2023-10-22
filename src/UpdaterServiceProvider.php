<?php

namespace Salahhusa9\Updater;

use Salahhusa9\Updater\Commands\UpdaterCommand;
use Salahhusa9\Updater\Contracts\Repository;
use Salahhusa9\Updater\RepositorySource\GithubRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class UpdaterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-updater')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-updater_table')
            ->hasCommand(UpdaterCommand::class);

        $this->app->singleton(Repository::class, function () {
            return new (config('updater.repository_source', GithubRepository::class))();
        });
    }
}
