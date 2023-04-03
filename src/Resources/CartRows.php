<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class CartRows extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected array $fillable = [
        'id',
        'id_product',
        'id_product_attribute',
        'id_address_delivery',
        'id_customization',
        'quantity',
    ];
}
