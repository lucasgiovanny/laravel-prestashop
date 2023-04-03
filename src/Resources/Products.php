<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Products extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected array $fillable = [
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
        'my_price',
    ];

    /**
     * Search for a specific price
     * Example Let’s say you want to retrieve the price for product 2, with tax, in a webservice field name my_price, then the result query is:
     * /api/products/2?price[my_price][use_tax]=1
     *
     * @param $search string
     * @param $value string
     * @param  string|null  $custom_field  string
     *
     * @throws \Exception
     */
    public function getPriceBy(string $search, string $value, string $custom_field = null): Products
    {
        $field = $custom_field ?: 'my_price';
        if ($field != 'my_price') {
            $this->addFillable($custom_field);
        }
        $this->filter('price['.$field.']['.$search.']', 'INNER', $value);

        return $this;
    }

    protected $xml_header = 'product';

    protected $url = 'products';
}
