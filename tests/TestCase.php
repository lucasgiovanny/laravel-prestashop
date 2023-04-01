<?php

namespace LucasGiovanny\LaravelPrestashop\Tests;

use LucasGiovanny\LaravelPrestashop\LaravelPrestashopServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelPrestashopServiceProvider::class,
        ];
    }
}
