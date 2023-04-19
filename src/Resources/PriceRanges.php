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

    protected static $messages = [
        'id_carrier.required' => 'Carrier is required',
        'id_carrier.numeric' => 'Carrier must be numeric',
        'delimiter1.required' => 'Delimiter 1 is required',
        'delimiter1.numeric' => 'Delimiter 1 must be numeric',
        'delimiter2.required' => 'Delimiter 2 is required',
        'delimiter2.numeric' => 'Delimiter 2 must be numeric',
    ];

    protected array $fillable = [
        'id_carrier',
        'delimiter1',
        'delimiter2',
    ];

    protected $xml_header = 'price_range';

    protected $url = 'price_ranges';
}
