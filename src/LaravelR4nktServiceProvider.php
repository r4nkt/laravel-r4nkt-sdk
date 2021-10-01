<?php

namespace R4nkt\LaravelR4nkt;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use R4nkt\LaravelR4nkt\Commands\LaravelR4nktCommand;

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
            ->hasConfigFile('r4nkt')
            // ->hasViews()
            // ->hasMigration('create_laravel-r4nkt-sdk_table')
            // ->hasCommand(LaravelR4nktCommand::class)
            ;
    }

    public function packageRegistered()
    {
        $this->app->bind('laravel-r4nkt-sdk', function($app) {
            return new LaravelR4nkt();
        });
    }
}
