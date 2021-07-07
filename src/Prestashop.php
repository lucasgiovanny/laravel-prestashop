<?php

namespace Lucasgiovanny\LaravelPrestashop;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use Lucasgiovanny\LaravelPrestashop\Models\Resource;

class Prestashop
{

    /**
     * All available resources on Prestashop webservice
     */
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

    /**
     * All allowed filters
     */
    public const FILTER_OPERATORS = [
        '|',
        ',',
        '=',
        'OR',
        'INTERVAL',
        'LITERAL',
        'BEGIN',
        'END',
        'CONTAINS',
    ];

    /**
     * Resource that will be called
     *
     * @var string
     */
    public $resource;

    /**
     * Field from the resource to be added to the request
     *
     * @var array
     */
    public $display;

    /**
     * Filters to be added to the request
     *
     * @var array
     */
    public $filters;

    /**
     * Define the limit for the request
     *
     * @var array|int
     */
    public $limit;

    /**
     * Define the sort fields for the request
     *
     * @var array
     */
    public $sort;

    /**
     * On-demand endpoint definition
     *
     * @var string
     */
    public $endpoint;

    /**
     * On-demand token definition
     *
     * @var string
     */
    public $token;

    /**
     * Headers for request
     *
     * @var array
     */
    protected $headers = [
        'Io-Format' => 'JSON',
        'Output-Format' => 'JSON',
    ];

    /**
     * Construct the class with dependencies
     *
     * @param HttpClient $http
     *
     * @return void
     */
    public function __construct(protected HttpClient $http)
    {
    }

    /**
     * Configure the Prestashop store
     *
     * @param string $endpoint
     * @param string $token
     *
     * @return self
     */
    public function shop(string $endpoint, string $token)
    {
        $this->endpoint = $endpoint;
        $this->token = $token;

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $resource
     * @param mixed  ...$arguments
     *
     * @return self
     */
    public function resource(string $resource, ...$arguments)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Define the request limit or index and limit
     *
     * @param int $limit
     * @param int $index
     *
     * @return self
     */
    public function limit(int $limit, int $index = null)
    {
        $this->limit = $index ? [$index, $limit] : $limit;

        return $this;
    }

    /**
     * Add sort fields by ASC
     *
     * @param string $field
     * @param string $order
     *
     * @return self
     */
    protected function sort(string $field, string $order)
    {
        $this->sort[] = [
            'value' => $field,
            'order' => $order,
        ];

        return $this;
    }

    /**
     * Add sort fields by DESC
     *
     * @param string $field
     *
     * @return self
     */
    public function sortBy(string $field)
    {
        $this->sort($field, "ASC");

        return $this;
    }

    /**
     * Add sort fields by DESC
     *
     * @param string $field
     *
     * @return self
     */
    public function sortByDesc(string $field)
    {
        $this->sort($field, "DESC");

        return $this;
    }

    /**
     * Alias for sortBy
     *
     * @param string $field
     *
     * @return self
     */
    public function orderBy(string $field)
    {
        $this->sort($field, "ASC");

        return $this;
    }

    /**
     * Alias for sortByDesc
     *
     * @param string $field
     *
     * @return self
     */
    public function orderByDesc(string $field)
    {
        $this->sort($field, "DESC");

        return $this;
    }

    /**
     * Shortcut for display method
     *
     * @param string|array $fields
     *
     * @return self
     */
    public function select($fields)
    {
        return $this->display($fields);
    }

    /**
     * Select fields to be returned by webservice
     *
     * @param string|array $fields
     *
     * @return self
     */
    public function display($fields)
    {
        $this->display = is_array($fields) ? $fields : [$fields];

        return $this;
    }

    /**
     * Add a filter to the webservice call
     *
     * @param string       $field
     * @param string       $operatorOrValue
     * @param string|array $value
     *
     * @return self
     */
    public function filter(string $field, string $operatorOrValue, $value = null)
    {
        $operator = $value ? $operatorOrValue : '=';

        if (!in_array(strtoupper($operator), self::FILTER_OPERATORS)) {
            throw new Exception('Invalid filter operator');
        }

        $this->filters[] = [
            'field' => $field,
            'operator' => strtoupper($operator),
            'value' => $value ?: $operatorOrValue,
        ];

        return $this;
    }

    /**
     * Shortcut to filter method
     *
     * @param string       $field
     * @param string       $operatorOrValue
     * @param string|array $value
     *
     * @return self
     */
    public function where(string $field, string $operatorOrValue, $value = null)
    {
        return $this->filter($field, $operatorOrValue, $value);
    }

    /**
     * Execute the get request
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->call("get");
    }

    /**
     * Execute the get request and return first result
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function first()
    {
        $get = $this->call("get");
        return $get->isNotEmpty() ? $get->first() : null;
    }

    /**
     * Execute the get request with the condition applied
     *
     * @param int $id 
     * 
     * @return \Illuminate\Support\Collection|null
     */
    public function find(int $id)
    {
        if ($this->filters) {
            throw new Exception("You can not use find method along with filters");
        }

        $this->filters = [
            [
                'field' => 'id',
                'operator' => '=',
                'value' => $id,
            ]
        ];

        $get = $this->call("get");

        return $get->isNotEmpty() ? $get->first() : null;
    }

    /**
     * Execute the post request
     *
     * @return \Illuminate\Support\Collection
     */
    public function create()
    {
        return $this->call("post");
    }

    /**
     * Execute the put request
     *
     * @return \Illuminate\Support\Collection
     */
    public function update()
    {
        return $this->call("put");
    }

    /**
     * Execute the delete request
     *
     * @return \Illuminate\Support\Collection
     */
    public function delete()
    {
        return $this->call("delete");
    }

    /**
     * Internal method to make the correct request call
     *
     * @param string $method
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws Exception
     */
    protected function call(string $method)
    {
        $this->method = in_array($method, ["get", "post", "put", "delete"]) ? $method : null;

        if ($this->canExecute()) {
            return $this->response($this->exec());
        }

        throw new Exception("Error occur when trying to execute the API call");
    }

    /**
     * Check if the request can be executed
     *
     * @return bool
     *
     * @throws Exception
     */
    protected function canExecute()
    {
        if (!$this->resource) {
            throw new Exception("You need to define a resource.");
        }

        if (!$this->method) {
            throw new Exception("You need to define a method.");
        }

        if (!$this->url()) {
            throw new Exception("No endpoint/URL defined.");
        }

        if (!$this->token()) {
            throw new Exception("No token defined.");
        }

        return true;
    }

    /**
     * Execute the request to Prestashop webservice
     *
     * @return array
     */
    protected function exec()
    {
        $url = trim($this->url(), "/") . "/" . trim($this->resource, "/");


        $res = $this->http->request(
            strtoupper($this->method),
            $url,
            [
                RequestOptions::AUTH => [$this->token(), null],
                RequestOptions::HEADERS => $this->headers,
                RequestOptions::QUERY => $this->query(),
            ]
        );

        return $res->getBody() ? json_decode($res->getBody(), true) : null;
    }

    /**
     * Prepare query for request
     *
     * @return array
     */
    protected function query()
    {
        $query = [
            'display' => $this->display ?
                "[" . implode(",", $this->display) . "]" : 'full',
        ];

        if ($this->limit) {
            $query['limit'] = is_array($this->limit) ?
                "{$this->limit[0]}, {$this->limit[1]}"
                : $this->limit;
        }

        if ($this->filters) {
            foreach ($this->filters as $filter) {
                if ($filter['operator'] === "|" || $filter['operator'] === "OR") {
                    $value = "[" . implode("|", $filter['value']) . "]";
                }

                if ($filter['operator'] === "," || $filter['operator'] === "INTERVAL") {
                    $value = "[" . implode(",", $filter['value']) . "]";
                }

                if ($filter['operator'] === "=" || $filter['operator'] === "LITERAL") {
                    $value = "[" . $filter['value'] . "]";
                }

                if ($filter['operator'] === "BEGIN") {
                    $value = "[" . $filter['value'] . "]%";
                }

                if ($filter['operator'] === "END") {
                    $value = "%[" . $filter['value'] . "]";
                }

                if ($filter['operator'] === "CONTAINS") {
                    $value = "%[" . $filter['value'] . "]%";
                }

                $query["filter[" . $filter['field'] . "]"] = $value;
            }
        }

        if ($this->sort) {
            foreach ($this->sort as $sort) {
                $sortQuery[] = "{$sort['value']}_{$sort['order']}";
            }

            $query['sort'] = "[" . implode(",", $sortQuery) . "]";
        }


        return $query;
    }

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    protected function token()
    {
        return $this->token ?: config('prestashop.shop.token');
    }

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    protected function url()
    {
        return $this->endpoint ?: config('prestashop.shop.endpoint');
    }

    /**
     * Format and delivery the response as Laravel Collection
     *
     * @param array $response
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws Exception
     */
    protected function response(array $response)
    {
        $response = $response[$this->resource] ?? $response;

        foreach ($response as $element) {
            $data[] = new Resource($this->resource, $element);
        }

        return collect($data ?? null);
    }

    /**
     * Create the method for each webservice resource
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return void
     */
    public function __call(string $method, array $arguments)
    {
        if (in_array($method, self::RESOURCES)) {
            return $this->resource($method, $arguments);
        }

        throw new Exception("This is not a valid resource");
    }
}
