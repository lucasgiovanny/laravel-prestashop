<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;

class OrderDetials extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'id_order',
        'product_id',
        'product_attribute_id',
        'product_quantity_reinjected',
        'group_reduction',
        'discount_quantity_applied',
        'download_hash',
        'download_deadline',
        'id_order_invoice',
        'id_warehouse',
        'id_shop',
        'id_customization',
        'product_name',
        'product_quantity',
        'product_quantity_in_stock',
        'product_quantity_return',
        'product_quantity_refunded',
        'product_price',
        'reduction_percent',
        'reduction_amount',
        'reduction_amount_tax_incl',
        'reduction_amount_tax_excl',
        'reduction_amount_tax_excl',
        'product_quantity_discount',
        'product_ean13',
        'product_isbn',
        'product_upc',
        'product_mpn',
        'product_reference',
        'product_supplier_reference',
        'product_weight',
        'tax_computation_method',
        'id_tax_rules_group',
        'ecotax',
        'ecotax_tax_rate',
        'download_nb',
        'unit_price_tax_incl',
        'unit_price_tax_excl',
        'total_price_tax_incl',
        'total_price_tax_excl',
        'total_shipping_price_tax_excl',
        'total_shipping_price_tax_incl',
        'purchase_supplier_price',
        'original_product_price',
        'original_wholesale_price',
        'total_refunded_tax_excl',
        'total_refunded_tax_incl',
        'associations'
    ];
    protected $url = 'order_histories';
}
