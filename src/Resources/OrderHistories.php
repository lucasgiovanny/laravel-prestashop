<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class OrderHistories extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [
        'id_employee' => 'nullable|numeric',
        'id_order_state' => 'required|numeric',
        'id_order' => 'required|numeric',
        'date_add' => 'nullable|date',
    ];

    public static $messages = [
        'id_employee.numeric' => 'Employee must be numeric',
        'id_order_state.required' => 'Order state is required',
        'id_order_state.numeric' => 'Order state must be numeric',
        'id_order.required' => 'Order is required',
        'id_order.numeric' => 'Order must be numeric',
        'date_add.date' => 'Date must be a date',
    ];

    protected array $fillable = [
        'id',
        'id_employee',
        'id_order_state',
        'id_order',
        'date_add',
    ];

    protected $xml_header = 'order_history';

    protected $url = 'order_histories';
}
