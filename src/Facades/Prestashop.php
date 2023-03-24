<?php

namespace LucasGiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use LucasGiovanny\LaravelPrestashop\Prestashop as PrestashopService;

/**
 * @see \LucasGiovanny\LaravelPrestashop\Prestashop
 */
class Prestashop extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance(PrestashopService::class);

        return PrestashopService::class;
    }
}
