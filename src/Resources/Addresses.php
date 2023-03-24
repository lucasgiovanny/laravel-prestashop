<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Addresses extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected static $rules = [
        'id_customer' => 'nullable|numeric',
        'id_country' => 'required|numeric',
        'alias' => 'required|string',
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'address1' => 'required|string',
        'city' => 'required|regex:/^[^!<>;?=+@#"°{}_$%]*$/u',
        'postcode' => 'required|regex:/^[a-zA-Z 0-9-]+$/',
    ];

    //Use this for custom messages
    protected static $messages = [
        'id_customer.numeric' => 'Customer must be numeric',
        'id_country.required' => 'Country is required',
        'alias.required' => 'Alias is required',
    ];

    protected $fillable = [
        'id',
        'id_customer',
        'id_country',
        'id_manufacturer',
        'id_supplier',
        'id_warehouse',
        'id_state',
        'alias',
        'company',
        'lastname',
        'firstname',
        'vat_number',
        'address1',
        'address2',
        'postcode',
        'city',
        'other',
        'phone',
        'phone_mobile',
        'dni',
        'deleted',
        'date_add',
        'date_upd',
    ];

    protected $xml_header = 'address';

    protected $url = 'addresses';
}
