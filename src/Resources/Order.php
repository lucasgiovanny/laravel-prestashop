<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Query;

class Order extends Resource
{
    use Query\Searchable;

    protected static $rules = [
        'id_address_delivery' => 'required|numeric',
        'id_address_invoice' => 'required|numeric',
        'id_cart' => 'required|numeric',
        'id_currency' => 'required|numeric',
        'id_lang' => 'required|numeric',
        'id_customer' => 'required|numeric',
        'id_carrier' => 'required|numeric',
        'module' => 'required|regex:/^[a-zA-Z0-9_-]+$/',
        'payment' => 'required|regex:/^[^<>={}]*$/u',
        'total_paid' => 'required|numeric',
        'total_paid_real' => 'required|numeric',
        'total_products' => 'required|numeric',
        'total_products_wt' => 'required|numeric',
        'conversion_rate' => 'required|numeric',
        'associations.order_rows' => 'array',
        'associations.order_rows.*.product_id' => 'required|numeric',
        'associations.order_rows.*.product_attribute_id' => 'nullable|numeric',
        'associations.order_rows.*.product_quantity' => 'required|numeric',
        'associations.order_rows.*.product_name' => 'nullable|string',
        'associations.order_rows.*.product_ean13' => 'nullable|regex:/^[0-9]{0,13}$/',
        'associations.order_rows.*.product_isbn' => 'nullable|regex:/^[0-9-]{0,32}$/',
        'associations.order_rows.*.product_upc' => 'nullable|regex:/^[0-9]{0,12}$/',
        'associations.order_rows.*.product_price' => 'nullable|numeric',
        'associations.order_rows.*.id_customization' => 'nullable|numeric',
        'associations.order_rows.*.unit_price_tax_incl' => 'nullable|numeric',
        'associations.order_rows.*.unit_price_tax_excl' => 'nullable|numeric',
    ];

    protected static $messages = [
        'id_address_delivery.required' => 'Delivery address is required',
        'id_address_invoice.required' => 'Invoice address is required',
        'id_cart.required' => 'Cart is required',
        'id_currency.required' => 'Currency is required',
        'id_lang.required' => 'Lang is required',
        'id_customer.required' => 'Customer is required',
        'id_carrier.required' => 'Carrier is required',
        'module.required' => 'Module is required',
        'current_state.required' => 'Current state is required!',
        'total_paid.required' => 'Total paid is required',
        'total_paid_real.required' => 'Total paid real is required',
        'total_products.required' => 'Total products is required',
        'total_products_wt.required' => 'Total products wt is required',
    ];

    protected array $fillable = [
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
        'associations',
    ];

    /**
     * Setting attribute for associations with right keys
     *
     * @return void
     */
    public function setAssociationsAttribute($associations)
    {
        if (isset($associations['order_rows'])) {
            $array = [];
            foreach ($associations['order_rows'] as $k => $association) {
                $array['order_row'.$k] = $association;
            }
            $this->attributes['associations']['order_rows'] = $array;
        } else {
            $this->attributes['associations'] = $associations;
        }
    }
}
