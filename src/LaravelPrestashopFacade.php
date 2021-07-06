<?php

namespace Lucasgiovanny\LaravelPrestashop;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lucasgiovanny\LaravelPrestashop\LaravelPrestashop
 */
class LaravelPrestashopFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LaravelPrestashop::class;
    }
}
