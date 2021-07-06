<?php

namespace Lucasgiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use Lucasgiovanny\LaravelPrestashop\Prestashop as PrestashopService;

/**
 * @see \Lucasgiovanny\LaravelPrestashop\Prestashop
 */
class Prestashop extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PrestashopService::class;
    }
}
