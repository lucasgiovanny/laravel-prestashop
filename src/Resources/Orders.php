<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;


use Lucasgiovanny\LaravelPrestashop\Prestashop;

use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;

class Orders extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id_address_delivery',
        'id_address_invoice',
        'id_cart',
        'id_currency',
        'id_lang',
        'id_customer',
        'id_carrier',
        'current_state',
        'module',
        'invoice_number',
        'invoice_date',
        'delivery_number',
        'delivery_date',
        'valid',
        'date_add',
        'date_upd',
        'shipping_number',
        'note',
        'id_shop_group',
        'id_shop',
        'secure_key',
        'payment',
        'recyclable',
        'gift',
        'gift_message',
        'mobile_theme',
        'total_discounts',
        'total_discounts_tax_incl',
        'total_discounts_tax_excl',
        'total_paid',
        'total_paid_tax_incl',
        'total_paid_tax_excl',
        'total_paid_real',
        'total_products',
        'total_products_wt',
        'total_shipping',
        'total_shipping_tax_incl',
        'total_shipping_tax_excl',
        'carrier_tax_rate',
        'total_wrapping',
        'total_wrapping_tax_incl',
        'total_wrapping_tax_excl',
        'round_mode',
        'round_type',
        'conversion_rate',
        'reference',
        'associations'
    ];
    protected $url = 'orders';
}
