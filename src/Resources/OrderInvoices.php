<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class OrderInvoices extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
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

    protected $url = 'order_invoices';
}
