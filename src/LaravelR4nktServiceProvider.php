<?php

namespace R4nkt\\LaravelR4nkt\LaravelR4nkt;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use R4nkt\\LaravelR4nkt\LaravelR4nkt\Commands\LaravelR4nktCommand;

class LaravelR4nktServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-r4nkt-sdk')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-r4nkt-sdk_table')
            ->hasCommand(LaravelR4nktCommand::class);
    }
}
