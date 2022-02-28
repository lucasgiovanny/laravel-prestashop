<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;


use Lucasgiovanny\LaravelPrestashop\Query;
use Lucasgiovanny\LaravelPrestashop\Persistance;

class OrderHistories extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
        'id',
        'id_employee',
        'id_order_state',
        'id_order',
        'date_add',
    ];
    protected $url = 'order_histories';
}
