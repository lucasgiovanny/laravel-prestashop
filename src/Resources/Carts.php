<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Carts extends Model
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [

        'id_currency' => 'required|numeric',
        'id_lang' => 'required|numeric',
        'id_address_delivery' => 'nullable|numeric',
        'id_address_invoice' => 'nullable|numeric',
        'id_customer' => 'nullable|numeric',
        'id_guest' => 'nullable|numeric',
        'id_shop_group' => 'nullable|numeric',
        'id_shop' => 'nullable|nullable',
        'id_carrier' => 'nullable|nullable',
        'gift_message' => 'nullable|string',
        'associations.cart_rows' => 'array',
        'associations.cart_rows.*.id_product' => 'required|numeric',
        'associations.cart_rows.*.id_product_attribute' => 'nullable|numeric',
        'associations.cart_rows.*.id_address_delivery' => 'required|numeric',
        'associations.cart_rows.*.id_customization' => 'nullable|numeric',
        'associations.cart_rows.*.quantity' => 'required|numeric',
    ];

    //Use this for custom messages
    protected static $messages = [
        'id_currency.numeric' => 'Currency must be numeric',
        'id_currency.required' => 'Currency is required',
        'id_lang.required' => 'Lang is required',
        'associations.required' => 'associations is required',
        'associations.array' => 'associations must be an array',
        'associations.cart_rows.required' => 'cart_rows is required',
        'associations.cart_rows.array' => 'cart_rows must be an array',
    ];

    protected array $fillable = [
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
        'associations',
    ];

    protected array $attributes = [
        'associations' => [],
    ];

    public function setAssociationsAttribute($associations)
    {
        if (isset($associations['cart_rows'])) {
            $array = [];
            foreach ($associations['cart_rows'] as $k => $association) {
                $array['cart_row'.$k] = $association;
            }
            $this->attributes['associations']['cart_rows'] = $array;
        } else {
            $this->attributes['associations'] = $associations;
        }
    }

    protected $xml_header = 'cart';

    protected $url = 'carts';
}
