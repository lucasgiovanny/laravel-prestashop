<?php

use Illuminate\Support\Collection;
use LucasGiovanny\LaravelPrestashop\Facades\Order;
use LucasGiovanny\LaravelPrestashop\Prestashop;
use LucasGiovanny\LaravelPrestashop\Resources\Order as OrderResource;
use Mockery\MockInterface;

it('should be able to get a single order', function () {
    $this->partialMock(Prestashop::class, function (MockInterface $mock) {
        $mock->shouldReceive('get')->andReturn(prestashopMock('orders/single'));
    });

    $order = Order::find(6);

    expect($order)
        ->toBeInstanceOf(OrderResource::class)
        ->and($order->id)->toBe(6)
        ->and($order->date_add)->toBe('2022-02-23 14:26:52')
        ->and($order->date_upd)->toBe('2022-02-23 14:29:32');
});

it('should be able to get orders', function () {
    $this->partialMock(Prestashop::class, function (MockInterface $mock) {
        $mock->shouldReceive('get')->andReturn(prestashopMock('orders/orders'));
    });

    $order = Order::all();

    expect($order)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(2)
        ->and($order->first())->toBeInstanceOf(OrderResource::class)
        ->and($order->first()->id)->toBe(6);
});
