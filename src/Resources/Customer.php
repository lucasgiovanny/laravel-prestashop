<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use LucasGiovanny\LaravelPrestashop\Persistance;
use LucasGiovanny\LaravelPrestashop\Query;

class Customer extends Model
{
    use Query\Searchable;
    use Persistance\Storable;

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

    protected $url = 'customers';
}
