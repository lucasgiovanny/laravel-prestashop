<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class PriceRanges extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [
        'id_carrier' => 'required|numeric',
        'delimiter1' => 'required|numeric',
        'delimiter2' => 'required|numeric',
    ];

    protected array $fillable = [
        'id_carrier',
        'delimiter1',
        'delimiter2',
    ];

    protected $xml_header = 'price_range';

    protected $url = 'price_ranges';
}
