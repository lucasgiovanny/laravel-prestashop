<?php

namespace LucasGiovanny\LaravelPrestashop\Tests;

use LucasGiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider;
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
