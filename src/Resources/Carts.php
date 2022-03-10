<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;
use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;
class Carts extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'id_address_delivery',
        'id_address_invoice',
        'id_currency',
        'id_customer',
        'id_guest',
        'id_lang',
        'id_shop_group',
        'id_shop',
        'id_carrier',
        'recyclable',
        'gift',
        'gift_message',
        'mobile_theme',
        'delivery_option',
        'secure_key',
        'allow_seperated_package',
        'date_add',
        'date_upd',
        'associations.cart_rows',
    ];
   protected $casts = [
        'associations' => CartRows::class,
    ];
}
