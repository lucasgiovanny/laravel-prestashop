<?php

namespace LucasGiovanny\LaravelPrestashop\Facades;

use Illuminate\Support\Facades\Facade;
use RuntimeException;

class Order extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor(): string
    {
        return \LucasGiovanny\LaravelPrestashop\Resources\Order::class;
    }
}
