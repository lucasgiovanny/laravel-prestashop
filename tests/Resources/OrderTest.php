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

it('should be able to select specific orders fields', function () {
    $this->partialMock(Prestashop::class, function (MockInterface $mock) {
        $json = collect(prestashopMock('orders/single'))->only(['id', 'date_add'])->toArray();
        $mock->shouldReceive('get')->andReturn([$json]);
    });

    $order = Order::select(['id', 'date_add'])->get();

    expect($order)
        ->toBeInstanceOf(Collection::class)
        ->and($order->first())->toBeInstanceOf(OrderResource::class)
        ->and($order->first()->attributes())->toHaveKeys([
            'id',
            'date_add',
        ]);
});

todo('should be able to get orders with filters');
todo('should be able to sort orders');
todo('should be able to get orders with filters and limit');
todo('should be able to get orders with limit');
