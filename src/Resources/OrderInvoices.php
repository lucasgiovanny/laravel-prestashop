<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class OrderInvoices extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [
        'id_order' => 'required|numeric',
        'number' => 'required|numeric',
        'delivery_number' => 'nullable|numeric',
        'delivery_date' => 'nullable|date',
        'date_add' => 'nullable|date',

    ];

    protected static $messages = [
        'id_order.required' => 'Order is required',
        'id_order.numeric' => 'Order must be numeric',
        'number.required' => 'Number is required',
        'number.numeric' => 'Number must be numeric',
        'delivery_number.numeric' => 'Delivery number must be numeric',
        'delivery_date.date' => 'Delivery date must be a date',
        'date_add.date' => 'Date must be a date',
    ];

    protected array $fillable = [
        'id',
        'id_order',
        'number',
        'delivery_number',
        'delivery_date',
        'total_discount_tax_excl',
        'total_discount_tax_incl',
        'total_paid_tax_excl',
        'total_paid_tax_incl',
        'total_products',
        'total_products_wt',
        'total_shipping_tax_excl',
        'total_shipping_tax_incl',
        'shipping_tax_computation_method',
        'total_wrapping_tax_excl',
        'total_wrapping_tax_incl',
        'shop_address',
        'note',
        'date_add',
    ];

    protected $xml_header = 'order_invoice';

    protected $url = 'order_invoices';
}
