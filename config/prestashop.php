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
        'endpoint' => env('PRESTASHOP_ENDPOINT'),
        'token' => env('PRESTASHOP_TOKEN'),
    ],

];
