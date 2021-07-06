<?php

namespace Lucasgiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use Lucasgiovanny\LaravelPrestashop\Prestashop;

/**
 * @see \Lucasgiovanny\LaravelPrestashop\Prestashop
 */
class LaravelPrestashop extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Prestashop::class;
    }
}
