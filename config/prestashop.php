<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Prestashop shop configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the connection configuration for your store
    |
    */
    'shop' => [
        'shop_url' => env('PRESTASHOP_URL'),
        'endpoint' => 'api',
        'token' => env('PRESTASHOP_TOKEN'),
    ],

];
