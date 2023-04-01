<?php

namespace LucasGiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use LucasGiovanny\LaravelPrestashop\Prestashop as PrestashopService;
use RuntimeException;

/**
 * @see \LucasGiovanny\LaravelPrestashop\Prestashop
 */
class Prestashop extends Facade
{
    /**
     * Get the registered name of the component.
     *
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(PrestashopService::class);

        return PrestashopService::class;
    }
}
