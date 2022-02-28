<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;
use Pdik\LaravelPrestaShop\Query;
use Pdik\LaravelPrestaShop\Persistance;

class Customer extends Model
{
    use Query\Findable;
    use Persistance\Storable;

    protected $fillable = [
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
        'associations'
    ];
    protected $url = 'customers';
}
