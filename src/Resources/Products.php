<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

use Lucasgiovanny\LaravelPrestashop\Prestashop;

use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;

class Products extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'id_manufacturer',
        'id_supplier',
        'id_category_default',
        'new',
        'cache_default_attribute',
        'id_default_image',
        'id_default_combination',
        'id_tax_rules_group',
        'position_in_category',
        'manufacturer_name',
        'quantity',
        'type',
        'id_shop_default',
        'reference',
        'supplier_reference',
        'location',
        'width',
        'height',
        'depth',
        'weight',
        'quantity_discount',
        'ean13',
        'isbn',
        'upc',
        'mpn',
        'cache_is_pack',
        'cache_has_attachments',
        'is_virtual',
        'state',
        'additional_delivery_times',
        'delivery_in_stock',
        'delivery_out_stock',
        'on_sale',
        'online_only',
        'ecotax',
        'minimal_quantity',
        'low_stock_threshold',
        'low_stock_alert',
        'price',
        'wholesale_price',
        'unity',
        'unit_price_ratio',
        'additional_shipping_cost',
        'customizable',
        'text_fields',
        'uploadable_files',
        'active',
        'redirect_type',
        'id_type_redirected',
        'available_for_order',
        'available_date',
        'show_condition',
        'condition',
        'show_price',
        'indexed',
        'visibility',
        'advanced_stock_management',
        'date_add',
        'date_upd',
        'pack_stock_type',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'link_rewrite',
        'name',
        'description',
        'description_short',
        'available_now',
        'available_later',
        'associations',

    ];
    protected $xml_header = "product";
    protected $url = 'products';
}
