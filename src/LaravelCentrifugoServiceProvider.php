<?php

namespace Meetjet\LaravelCentrifugo;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Meetjet\LaravelCentrifugo\Commands\LaravelCentrifugoCommand;

class LaravelCentrifugoServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-centrifugo')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-centrifugo_table')
            ->hasCommand(LaravelCentrifugoCommand::class);
    }
}
