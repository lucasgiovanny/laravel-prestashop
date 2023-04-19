<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Customer extends Resource
{
    use Query\Searchable;
    use Persistance\Storable;

    protected static $rules = [
        'id_default_group' => 'nullable|numeric',
        'id_lang' => 'nullable|numeric',
        'newsletter_date_add' => 'nullable|date',
        'ip_registration_newsletter' => 'nullable|string',
        'passwd' => 'required|string',
        'lastname' => 'required|string',
        'firstname' => 'required|string',
        'email' => 'required|unique:customers',
        'id_gender' => 'nullable|numeric',
        'birthday' => 'nullable|date',
        'newsletter' => 'nullable|boolean',
        'optin' => 'nullable|boolean',
        'website' => 'nullable|string',
        'company' => 'nullable|string',
        'siret' => 'nullable|string',
        'ape' => 'nullable|string',
        'outstanding_allow_amount' => 'nullable|numeric',
        'show_public_prices' => 'nullable|boolean',
        'id_risk' => 'nullable|numeric',
        'max_payment_days' => 'nullable|numeric',
        'active' => 'nullable|boolean',
        'note' => 'nullable|string',
        'is_guest' => 'nullable|boolean',
        'id_shop' => 'nullable|numeric',
        'id_shop_group' => 'nullable|numeric',
        'associations' => 'nullable|array',
    ];

    protected static $messages = [
        'id_default_group.numeric' => 'Default group must be numeric',
        'id_lang.numeric' => 'Lang must be numeric',
        'newsletter_date_add.date' => 'Newsletter date add must be a date',
        'ip_registration_newsletter.string' => 'Ip registration newsletter must be a string',
        'passwd.required' => 'Password is required',
        'passwd.string' => 'Password must be a string',
        'lastname.required' => 'Lastname is required',
        'lastname.string' => 'Lastname must be a string',
        'firstname.required' => 'Firstname is required',
        'firstname.string' => 'Firstname must be a string',
        'email.required' => 'Email is required',
        'email.unique' => 'Email must be unique',
        'id_gender' => 'Gender must be numeric',
        'birthday.date' => 'Birthday must be a date',
    ];

    protected array $fillable = [
        'id',
        'id_default_group',
        'id_lang',
        'newsletter_date_add',
        'ip_registration_newsletter',
        'last_passwd_gen',
        'secure_key',
        'deleted',
        'passwd',
        'lastname',
        'firstname',
        'email',
        'id_gender',
        'birthday',
        'newsletter',
        'optin',
        'website',
        'company',
        'siret',
        'ape',
        'outstanding_allow_amount',
        'show_public_prices',
        'id_risk',
        'max_payment_days',
        'active',
        'note',
        'is_guest',
        'id_shop',
        'id_shop_group',
        'date_add',
        'date_upd',
        'reset_password_token',
        'reset_password_validity',
        'associations',
    ];

    protected array $attributes = [
        'associations' => [],
    ];

    protected $xml_header = 'customer';

    protected $url = 'customers';
}
