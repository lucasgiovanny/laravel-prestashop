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

    protected static $rules = [
        'id_address_delivery' => 'required|numeric',
        'id_address_invoice' => 'required|numeric',
        'id_cart' => 'required|numeric',
        'id_currency' => 'required|numeric',
        'id_lang' => 'required|numeric',
        'id_customer' => 'required|numeric',
        'id_carrier' => 'required|numeric',
        'module' => 'required|string',
        'payment' => 'required|string',
        'total_paid' => 'required|numeric',
        'total_paid_real' => 'required|numeric',
        'total_products' => 'required|numeric',
        'total_products_wt' => 'required|numeric',
        'conversion_rate' => 'required|numeric',
        'associations' => 'array',
        'associations.order_rows' => 'array',
        'associations.order_rows.*.order_row' => 'array',
    ];

    //Use this for custom messages
    protected static $messages = [
        'id_address_delivery.required' => 'Delivery address is required',
        'id_address_invoice.required' => 'Invoice address is required',
        'id_cart.required' => 'Cart is required',
        'id_currency.required' => 'currency is required',
        'id_lang.required' => 'Lang is required',
        'id_customer.required' => 'Customer is required',
        'id_carrier.required' => 'carrier is required',
        'module.required' => 'Module is required',
        'total_paid.required' => 'Total paid is required',
        'total_paid_real.required' => 'Total paid real is required',
        'total_products.required' => 'Total products is required',
        'total_products_wt.required' => 'Total products wt is required',
    ];
    protected $fillable = [
        'id',
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
