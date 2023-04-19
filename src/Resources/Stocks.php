<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

class Stocks extends Resource
{
    protected static $rules = [
        'id_warehouse' => 'required|numeric',
        'id_product' => 'required|numeric',
        'id_product_attribute' => 'required|numeric',
        'reference' => 'nullable|string',
        'ean13' => 'nullable|string',
        'upc' => 'nullable|string',
        'isbn' => 'nullable|string',
        'mpn' => 'nullable|string',
        'physical_quantity' => 'required|numeric',
        'usable_quantity' => 'required|numeric',
        'price_te' => 'required|numeric',
    ];

    protected static $messages = [
        'id_warehouse.required' => 'The warehouse id field is required.',
        'id_warehouse.numeric' => 'The warehouse id field must be a number.',
        'id_product.required' => 'The product id field is required.',
        'id_product.numeric' => 'The product id field must be a number.',
        'id_product_attribute.required' => 'The product attribute id field is required.',
        'id_product_attribute.numeric' => 'The product attribute id field must be a number.',
        'physical_quantity.required' => 'The physical quantity field is required.',
        'physical_quantity.numeric' => 'The physical quantity field must be a number.',
        'usable_quantity.required' => 'The usable_quantity field is required.',
        'usable_quantity.numeric' => 'The usable quantity must be a number.',
        'price_te.required' => 'The price field is required.',
        'price_te.numeric' => 'The price field must be a number.',
    ];

    protected array $fillable = [
        'id',
        'id_warehouse',
        'id_product',
        'id_product_attribute',
        'real_quantity',
        'reference',
        'ean13',
        'isbn',
        'upc',
        'mpn',
        'physical_quantity',
        'usable_quantity',
        'price_te',
    ];

    protected $xml_header = 'stock';

    protected $url = 'stocks';
}
