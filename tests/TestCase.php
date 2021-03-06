<?php

namespace Lucasgiovanny\LaravelPrestashop\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lucasgiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lucasgiovanny\\LaravelPrestashop\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPrestashopServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        include_once __DIR__.'/../database/migrations/create_laravel-prestashop_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}
