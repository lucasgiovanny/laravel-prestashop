<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

class Categories extends Resource
{
    protected static $rules = [
        'id_parent' => 'nullable|numeric',
        'level_depth' => 'nullable|numeric',
        'active' => 'nullable|boolean',
        'id_shop_default' => 'nullable|numeric',
        'id_root_category' => 'nullable|boolean',
        'date_add' => 'nullable|date',
        'date_upd' => 'nullable|date',
        'name' => 'required|string',
        'link_rewrite' => 'required|string',
        'description' => 'nullable|string',
        'meta_title' => 'nullable|string',
        'meta_keywords' => 'nullable|string',
        'meta_description' => 'nullable|string',
        'associations' => 'nullable|array',
    ];

    protected static $messages = [
        'name.required' => 'The Name is required.',
        'name.string' => 'The Name must be a string.',
        'link_rewrite.required' => 'The link is required.',
        'link_rewrite.string' => 'The link must be a string.',
    ];

    protected array $fillable = [
        'id',
        'id_parent',
        'level_depth',
        'nb_products_recursive',
        'active',
        'id_shop_default',
        'id_root_category',
        'position',
        'date_add',
        'date_upd',
        'name',
        'link_rewrite',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'associations',
    ];

    protected $xml_header = 'category';

    protected $url = 'categories';
}
