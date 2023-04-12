<?php

namespace Lucasgiovanny\LaravelPrestashop;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use Lucasgiovanny\LaravelPrestashop\Models\Resource;
use Illuminate\Support\Str;

class Prestashop
{

    /**
     * All available resources on Prestashop web service
     */
    public const RESOURCES = [
        'addresses',
        'attachments',
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
    public string $resource;

    /**
     * Field from the resource to be added to the request
     *
     * @var array
     */
    public array $display;

    /**
     * Filters to be added to the request
     *
     * @var array
     */
    public array $filters;

    /**
     * Define the limit for the request
     *
     * @var array|int
     */
    public array|int $limit;

    /**
     * Define the sort fields for the request
     *
     * @var array
     */
    public array $sort;

    /**
     * On-demand endpoint definition
     *
     * @var string
     */
    public string $endpoint;

    /**
     * On-demand token definition
     *
     * @var string
     */
    public string $token;

    /**
     * Shop ID
     *
     * @var int
     */
    public int $shop;

    /**
     * Headers for request
     *
     * @var array
     */
    protected array $headers = [
        'Io-Format' => 'JSON',
        'Output-Format' => 'JSON',
    ];
    private ?string $method;

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
     * @param int|null $shop
     *
     * @return $this
     */
    public function shop(string $endpoint, string $token, int $shop = null): static
    {
        $this->endpoint = $endpoint;
        $this->token = $token;
        $this->shop = $shop;

        return $this;
    }

    /**
     * Configure the Prestashop store
     *
     * @param string $endpoint
     * @param string $token
     * @param int|null $shop
     *
     * @return $this
     */
    public function store(string $endpoint, string $token, int $shop = null): static
    {
        $this->shop($endpoint, $token, $shop);

        return $this;
    }

    /**
     * Set the resource to be used
     *
     * @param string $resource
     * @param mixed  ...$arguments
     *
     * @return $this
     */
    public function resource(string $resource, ...$arguments): static
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Define the request limit or index and limit
     *
     * @param int $limit
     * @param int|null $index
     *
     * @return $this
     */
    public function limit(int $limit, int $index = null): static
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
     * @return $this
     */
    protected function sort(string $field, string $order): static
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
     * @return $this
     */
    public function sortBy(string $field): static
    {
        $this->sort($field, "ASC");

        return $this;
    }

    /**
     * Add sort fields by DESC
     *
     * @param string $field
     *
     * @return $this
     */
    public function sortByDesc(string $field): static
    {
        $this->sort($field, "DESC");

        return $this;
    }

    /**
     * Alias for sortBy
     *
     * @param string $field
     *
     * @return $this
     */
    public function orderBy(string $field): static
    {
        $this->sort($field, "ASC");

        return $this;
    }

    /**
     * Alias for sortByDesc
     *
     * @param string $field
     *
     * @return $this
     */
    public function orderByDesc(string $field): static
    {
        $this->sort($field, "DESC");

        return $this;
    }

    /**
     * Shortcut for display method
     *
     * @param array|string $fields
     *
     * @return $this
     */
    public function select(array|string $fields): static
    {
        return $this->display($fields);
    }

    /**
     * Select fields to be returned by web service
     *
     * @param array|string $fields
     *
     * @return $this
     */
    public function display(array|string $fields): static
    {
        $this->display = is_array($fields) ? $fields : [$fields];

        return $this;
    }

    /**
     * Add a filter to the web service call
     *
     * @param string $field
     * @param string $operatorOrValue
     * @param array|string|null $value
     *
     * @return $this
     * @throws Exception
     */
    public function filter(string $field, string $operatorOrValue, array|string $value = null): static
    {
        $operator = $value ? $operatorOrValue : '=';

        if (! in_array(strtoupper($operator), self::FILTER_OPERATORS)) {
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
     * @param string $field
     * @param string $operatorOrValue
     * @param array|string|null $value
     *
     * @return $this
     * @throws Exception
     */
    public function where(string $field, string $operatorOrValue, array|string $value = null): static
    {
        return $this->filter($field, $operatorOrValue, $value);
    }

    /**
     * Execute the get request
     *
     * @return Collection
     * @throws Exception|GuzzleException
     */
    public function get(): Collection
    {
        return $this->call("get");
    }

    /**
     * Execute the get request and return first result
     *
     * @return Collection|null
     * @throws Exception|GuzzleException
     */
    public function first(): ?Collection
    {
        $get = $this->call("get");

        return $get->isNotEmpty() ? $get->first() : null;
    }

    /**
     * Execute the get request with the condition applied
     *
     * @param int $id
     *
     * @return Collection|null
     * @throws Exception|GuzzleException
     */
    public function find(int $id): ?Collection
    {
        if ($this->filters) {
            throw new Exception("You can not use find method along with filters");
        }

        $this->filters = [
            [
                'field' => 'id',
                'operator' => '=',
                'value' => $id,
            ],
        ];

        $get = $this->call("get");

        return $get->isNotEmpty() ? $get->first() : null;
    }

    /**
     * Internal method to make the correct request call
     *
     * @param string $method
     *
     * @return Collection
     *
     * @throws Exception|GuzzleException
     */
    protected function call(string $method): Collection
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
    protected function canExecute(): bool
    {
        if (! $this->resource) {
            throw new Exception("You need to define a resource.");
        }

        if (! $this->method) {
            throw new Exception("You need to define a method.");
        }

        if (! $this->url()) {
            throw new Exception("No endpoint/URL defined.");
        }

        if (! $this->token()) {
            throw new Exception("No token defined.");
        }

        return true;
    }

    /**
     * Execute the request to Prestashop web service
     *
     * @return array|null
     * @throws GuzzleException
     */
    protected function exec(): ?array
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

        return $res->getBody() ? json_decode((string) $res->getBody(), true) : null;

    }

    /**
     * Prepare query for request
     *
     * @return array
     */
    protected function query(): array
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

                if(Str::contains($filter['field'], 'date')){
                    $query['date'] = 1;
                }
            }
        }

        if ($this->sort) {
            foreach ($this->sort as $sort) {
                $sortQuery[] = "{$sort['value']}_{$sort['order']}";
            }

            $query['sort'] = "[" . implode(",", $sortQuery) . "]";
        }

        if ($this->shop) {
            $query['id_shop'] = $this->shop;
        }

        return $query;
    }

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    protected function token(): string
    {
        return $this->token ?: config('prestashop.shop.token');
    }

    /**
     * Define the endpoint for the request
     *
     * @return string
     */
    protected function url(): string
    {
        return $this->endpoint ?: config('prestashop.shop.endpoint');
    }

    /**
     * Format and delivery the response as Laravel Collection
     *
     * @param array|null $response
     *
     * @return Collection
     *
     * @throws Exception
     */
    protected function response(?array $response): Collection
    {
        if (! $response) {
            throw new Exception("No response from server");
        }

        $response = $response[$this->resource] ?? $response;

        foreach ($response as $element) {
            $data[] = new Resource($this->resource, $element);
        }

        return collect($data ?? null);
    }

    /**
     * Create the method for each web service resource
     *
     * @param string $method
     * @param array $arguments
     *
     * @return Prestashop
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        if (in_array($method, self::RESOURCES)) {
            return $this->resource($method, $arguments);
        }

        throw new Exception("This is not a valid resource");
    }
}
