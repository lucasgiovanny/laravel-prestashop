<?php

namespace Lucasgiovanny\LaravelPrestashop;

use Exception;
use GuzzleHttp\Client as HttpClient;

class LaravelPrestashop
{
    public const RESOURCES = [
        'addresses',
        'carriers',
        'cart_rules',
        'carts',
        'categories',
        'combinations',
        'configurations',
        'contacts',
        'content_management_system',
        'countries',
        'currencies',
        'customer_messages',
        'customer_threads',
        'customers',
        'customizations',
        'deliveries',
        'employees',
        'groups',
        'guests',
        'image_types',
        'images',
        'languages',
        'manufacturers',
        'messages',
        'order_carriers',
        'order_details',
        'order_histories',
        'order_invoices',
        'order_payments',
        'order_slip',
        'order_states',
        'orders',
        'price_ranges',
        'product_customization_fields',
        'product_feature_values',
        'product_features',
        'product_option_values',
        'product_options',
        'product_suppliers',
        'products', 'search',
        'shop_groups',
        'shop_urls',
        'shops',
        'specific_price_rules',
        'specific_prices',
        'states',
        'stock_availables',
        'stock_movement_reasons',
        'stock_movements',
        'stocks',
        'stores',
        'suppliers',
        'supply_order_details',
        'supply_order_histories',
        'supply_order_receipt_histories',
        'supply_order_states',
        'supply_orders',
        'tags',
        'tax_rule_groups',
        'tax_rules',
        'taxes',
        'translated_configurations',
        'warehouse_product_locations',
        'warehouses',
        'weight_ranges',
        'zones',
    ];

    public const FILTER_OPERATORS = [
        '|',
        ',',
        '=',
        'LIKE',
        'OR',
        'INTERVAL',
        'LITERAL',
        'END',
        'CONTAINS',
    ];

    public $display = "full";

    public $filters;

    public function __construct(protected HttpClient $http)
    {
    }

    public function shop(string $endpoint, string $token)
    {
        $this->endpoint = $endpoint;
        $this->token = $token;

        return $this;
    }

    public function model(string $model, ...$arguments)
    {
        $this->model = $model;

        return $this;
    }

    public function select(string | array $field)
    {
        return $this->display($field);
    }

    public function display(string | array $field)
    {
        $this->display = $field;

        return $this;
    }

    public function filter(string $field, string $operatorOrValue, string | array $value = null)
    {
        $operator = $value ? $operatorOrValue : '=';

        if (! in_array(strtoupper($operator), self::FILTER_OPERATORS)) {
            throw new Exception('Invalid filter operator');
        }

        $this->filters[] = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value ?: $operatorOrValue,
        ];

        return $this;
    }

    public function where(string $field, string $operatorOrValue, string $value = null)
    {
        return $this->filter($field, $operatorOrValue, $value);
    }

    public function get()
    {
        return $this->call("get");
    }

    public function create()
    {
        return $this->call("post");
    }

    public function update()
    {
        return $this->call("put");
    }

    public function delete()
    {
        return $this->call("delete");
    }

    protected function call(string $method)
    {
        $this->method = in_array($method, ["get", "post", "put", "delete"]) ? $method : null;

        if ($this->canExecute()) {
            return $this->exec();
        }

        throw new Exception("Error occur when trying to execute the API call");
    }

    protected function canExecute()
    {
        if (! $this->model) {
            throw new Exception("You need to define a resource.");
        }

        if (! $this->method) {
            throw new Exception("You need to define a method.");
        }
    }

    protected function exec()
    {
        $url = $this->url . "/" . $this->model;

        $headers = [];

        $res = $this->http->request(strtoupper($this->method), $url, $headers);

        return $res->getBody();
    }

    public function __call($method, $arguments)
    {
        if (in_array($method, self::RESOURCES)) {
            return $this->model($method, $arguments);
        }

        throw new Exception("This is not a valid resource");
    }
}
