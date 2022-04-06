<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;

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
