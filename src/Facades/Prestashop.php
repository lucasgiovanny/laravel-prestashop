<?php

namespace Lucasgiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use Lucasgiovanny\LaravelPrestashop\Prestashop as PrestashopService;
use RuntimeException;

/**
 * @see \Lucasgiovanny\LaravelPrestashop\Prestashop
 */
class Prestashop extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        self::clearResolvedInstance(PrestashopService::class);

        return PrestashopService::class;
    }
}
