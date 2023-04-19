<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Products extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [
        'id_manufacturer' => 'nullable|numeric',
        'id_supplier' => 'nullable|numeric',
        'id_category_default' => 'nullable|numeric',
        'id_tax_rules_group' => 'nullable|numeric',
        'id_shop_default' => 'nullable|numeric',
        'reference' => 'nullable|string',
        'supplier_reference' => 'nullable|string',
        'location' => 'nullable|string',
        'width' => 'nullable|float',
        'height' => 'nullable|float',
        'depth' => 'nullable|float',
        'weight' => 'nullable|float',
        'quantity_discount' => 'nullable|boolean',
        'ean13' => 'nullable|string',
        'isbn' => 'nullable|string',
        'upc' => 'nullable|string',
        'mpn' => 'nullable|string',
        'cache_is_pack' => 'nullable|boolean',
        'cache_has_attachments' => 'nullable|boolean',
        'is_virtual' => 'nullable|boolean',
        'state' => 'nullable|numeric',
        'additional_delivery_times' => 'nullable|numeric',
        'delivery_in_stock' => 'nullable|numeric',
        'delivery_out_stock' => 'nullable|numeric',
        'on_sale' => 'nullable|boolean',
        'online_only' => 'nullable|boolean',
        'ecotax' => 'nullable|numeric',
        'minimal_quantity' => 'nullable|numeric',
        'low_stock_threshold' => 'nullable|numeric',
        'low_stock_alert' => 'nullable|boolean',
        'price' => 'required|numeric',
        'wholesale_price' => 'nullable|numeric',
        'unity' => 'nullable|string',
        'additional_shipping_cost' => 'nullable|numeric',
        'customizable' => 'nullable|numeric',
        'text_fields' => 'nullable|numeric',
        'uploadable_files' => 'nullable|numeric',
        'active' => 'nullable|boolean',
        'redirect_type' => 'nullable|string',
        'id_type_redirected' => 'nullable|numeric',
        'available_for_order' => 'nullable|boolean',
        'available_date' => 'nullable|date',
        'condition' => 'nullable|string',
        'show_price' => 'nullable|boolean',
        'indexed' => 'nullable|boolean',
        'visibility' => 'nullable|string',
        'advanced_stock_management' => 'nullable|boolean',
        'date_add' => 'nullable|date',
        'date_upd' => 'nullable|date',
        'pack_stock_type' => 'nullable|numeric',
        'meta_description' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'meta_title' => 'nullable|string',
        'link_rewrite' => 'nullable|string',
        'name' => 'nullable|string',
        'description' => 'nullable|string',
        'description_short' => 'nullable|string',
        'available_now' => 'nullable|string',
        'available_later' => 'nullable|string',
        'associations' => 'nullable|array',
    ];

    public static $messages = [
        'price.required' => 'The Price is required.',
        'price.numeric' => 'The Price must be a number.',
    ];

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
