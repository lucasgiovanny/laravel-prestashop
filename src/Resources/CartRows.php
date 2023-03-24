<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class CartRows extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'id_product',
        'id_product_attribute',
        'id_address_delivery',
        'id_customization',
        'quantity',
    ];
}
