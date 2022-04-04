<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;

class PriceRanges extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected static $rules = [
        'id_carrier' => 'required|numeric',
        'delimiter1' => 'required|numeric',
        'delimiter2' => 'required|numeric'
    ];

    protected $fillable = [
        'id_carrier',
        'delimiter1',
        'delimiter2'
    ];
     protected $xml_header = "price_range";
    protected $url = 'price_ranges';
}
