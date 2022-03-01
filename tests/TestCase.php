<?php

namespace Lucasgiovanny\LaravelPrestashop\Tests;

use Lucasgiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelPrestashopServiceProvider::class,
        ];
    }
}
