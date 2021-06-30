<?php

namespace Lucasgiovanny\LaravelPrestashop;

use Lucasgiovanny\LaravelPrestashop\Commands\LaravelPrestashopCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPrestashopServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-prestashop')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-prestashop_table')
            ->hasCommand(LaravelPrestashopCommand::class);
    }
}
