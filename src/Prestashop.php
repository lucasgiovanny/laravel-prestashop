<?php

namespace LucasGiovanny\LaravelPrestashop;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;
use LucasGiovanny\LaravelPrestashop\Exceptions\ConfigException;
use LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectToPrestashopException;
use LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotFindResource;
use LucasGiovanny\LaravelPrestashop\Exceptions\PrestashopWebserviceException;

class Prestashop
{
    /**
     * Available resources from Prestashop Webservice
     *
     * @see https://devdocs.prestashop-project.org/8/webservice/reference/#available-resources
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
        'products',
        'search',
        'shop_groups',
        'shop_urls',
        'shops',
        'specific_price_rules',
        'specific_prices',
        'states',
        'stock_available',
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
     * Allowed filters from Prestashop Webservice
     *
     * @see https://devdocs.prestashop-project.org/8/webservice/cheat-sheet/#list-options
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
        'INNER',
    ];

    protected array $filters = [];

    /**
     * Construct the class with dependencies
     */
    public function __construct(protected ?HttpClient $client = null)
    {
        $this->client = $client ?: new HttpClient;
    }

    /**
     * Add a new filter to the request
     */
    public function addFilter(array $filter): void
    {
        $this->filters[] = $filter;
    }

    /*
     * Clean all filters of the request
     */
    public function cleanFilters(): void
    {
        $this->filters = [];
    }

    /****** refactor below this///

    /**
     * Resource that will be called
     */
    protected ?string $resource = null;

    /**
     * Field from the resource to be added to the request
     */
    protected array $display = [];

    /**
     * Define the limit for the request
     */
    protected array|int $limit;

    /**
     * Define the sort fields for the request
     */
    protected array $sort = [];

    /**
     * Prestashop store URL
     */
    protected ?string $shop_url = null;

    /**
     * Prestashop API token
     */
    public ?string $token = null;

    /**
     * In case of multiple shops, the shop id
     */
    public ?string $shop = null;

    /**
     * Default headers for the request
     */
    protected array $headers = [
        'Io-Format' => 'JSON',
        'Output-Format' => 'JSON',
    ];

    /**
     * Configure the Prestashop store
     */
    public function store(string $url, string $token, string $shop = null): self
    {
        $this->shop_url = $url;
        $this->token = $token;
        $this->shop = $shop;

        return $this;
    }

    /**
     * Set the resource to be used
     */
    public function resource(string $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Define the request limit or index and limit
     */
    public function limit(int $limit, int $index = null): self
    {
        $this->limit = $index ? [$index, $limit] : $limit;

        return $this;
    }

    /**
     * Prepare query for request
     */
    protected function query(): array
    {
        $query = [
            'display' => $this->display ?
                '['.implode(',', $this->display).']' : 'full',
        ];

        if ($this->limit) {
            $query['limit'] = is_array($this->limit) ?
                "{$this->limit[0]}, {$this->limit[1]}"
                : $this->limit;
        }

        if ($this->filters) {
            foreach ($this->filters as $filter) {
                if (isset($filter['operator'])) {
                    $value = null;
                    if ($filter['operator'] === '|' || $filter['operator'] === 'OR') {
                        $value = '['.implode('|', $filter['value']).']';
                    }

                    if ($filter['operator'] === ',' || $filter['operator'] === 'INTERVAL') {
                        $value = '['.implode(',', $filter['value']).']';
                    }

                    if ($filter['operator'] === '=' || $filter['operator'] === 'LITERAL') {
                        $value = '['.$filter['value'].']';
                    }

                    if ($filter['operator'] === 'BEGIN') {
                        $value = '['.$filter['value'].']%';
                    }

                    if ($filter['operator'] === 'END') {
                        $value = '%['.$filter['value'].']';
                    }

                    if ($filter['operator'] === 'CONTAINS') {
                        $value = '%['.$filter['value'].']%';
                    }

                    if ($filter['operator'] === 'INNER') {
                        $query[$filter['field']] = $filter['value'];
                    }
                    if (isset($value)) {
                        $query['filter['.$filter['field'].']'] = $value;
                    }
                }

                if (isset($filter['schema'])) {
                    $query = []; // clear because we wanted only a blank schema!
                    $query['schema'] = $filter['schema'];
                }
                if (isset($filter['field'])) {
                    if (Str::contains($filter['field'], 'date')) {
                        $query['date'] = 1;
                    }
                }
            }
        }

        if ($this->sort) {
            $sortQuery = [];
            foreach ($this->sort as $sort) {
                $sortQuery[] = "{$sort['value']}_{$sort['order']}";
            }

            $query['sort'] = '['.implode(',', $sortQuery).']';
        }

        if ($this->shop) {
            $query['id_shop'] = $this->shop;
        }

        return $query;
    }

    /**
     * Define the endpoint for the request
     */
    protected function token(): string
    {
        return $this->token ?: config('prestashop.shop.token');
    }

    /**
     * Execute the get request
     *
     * @throws CouldNotConnectToPrestashopException
     * @throws Exception
     */
    public function get(): array
    {
        try {
            return $this->call('get');
        } catch (GuzzleException $e) {
            throw new CouldNotConnectToPrestashopException($e->getMessage());
        } catch (Exception $e) {
            throw  new Exception($e->getMessage());
        }
    }

    /**
     * Handle post request
     *
     * @throws CouldNotConnectToPrestashopException|PrestashopWebserviceException
     */
    public function post($url, $body): array
    {
        try {
            $this->filters = [];

            return $this->call('post', $url, $body);
        } catch (CouldNotConnectToPrestashopException|ConfigException|GuzzleException $e) {
            throw new CouldNotConnectToPrestashopException($e->getMessage());
        }
    }

    /**
     * @throws CouldNotConnectToPrestashopException
     */
    public function put($url, $body): array
    {
        try {
            return $this->call('put', $url, $body);
        } catch (Exception|GuzzleException $e) {
            throw new CouldNotConnectToPrestashopException($e->getMessage());
        }
    }

    /**
     * @throws PrestashopWebserviceException
     */
    public function destroy($url, $id): array
    {
        try {
            return $this->call('delete', $url, ['id' => $id]);
        } catch (GuzzleException|ConfigException|CouldNotConnectToPrestashopException|PrestashopWebserviceException $e) {
            throw new PrestashopWebserviceException($e->getMessage());
        }
    }

    /**
     * Internal method to make the correct request call
     *
     *
     * @throws ConfigException
     * @throws CouldNotConnectToPrestashopException
     * @throws GuzzleException
     * @throws PrestashopWebserviceException
     */
    protected function call(string $method, string $url = null, mixed $body = null): array
    {
        $this->method = in_array($method, ['get', 'post', 'put', 'delete']) ? $method : null;

        if ($this->canExecute()) {
            $result = $this->exec($url, $body);

            return $this->response($result);
        }

        throw new CouldNotConnectToPrestashopException('Error occur when trying to execute the API call');
    }

    /**
     * Check if the request can be executed
     *
     *
     * @throws ConfigException
     */
    protected function canExecute(): bool
    {
        if (! $this->method) {
            throw new ConfigException('You need to define a method.');
        }

        if (! $this->shopUrl()) {
            throw new ConfigException('No endpoint/ URL defined.');
        }

        if (! $this->token()) {
            throw new ConfigException('Token is not configured');
        }

        return true;
    }

    /**
     * Execute the request to Prestashop web service
     *
     * @throws GuzzleException
     * @throws PrestashopWebserviceException
     * @throws Exception
     */
    protected function exec(string $url = null, mixed $body = null): ?array
    {
        if (isset($url)) {
            $url = $this->formatUrl($url);
        } elseif (isset($this->resource)) {
            $url = trim($this->shopUrl(), '/').'/'.trim($this->resource, '/');
        }

        if ($this->method == 'post') {
            $headers = [
                'Content-Type' => 'text/xml; charset=UTF8',
                'Io-Format' => 'JSON',
                'Output-Format' => 'JSON',
            ];
        } else {
            $headers = $this->headers;
        }
        if ($this->method == 'delete') {
            $query = ['id' => '['.$body['id'].']'];
            $body = null; //reset body
        } else {
            $query = $this->query();
        }

        try {
            $res = $this->client->request(
                strtoupper($this->method),
                $url,
                [
                    RequestOptions::ALLOW_REDIRECTS,
                    RequestOptions::AUTH => [$this->token(), null],
                    RequestOptions::HEADERS => $headers,
                    RequestOptions::QUERY => $query,
                    'body' => $body,
                ],
            );

            return $res->getBody() ? json_decode((string) $res->getBody(), true) : null;
        } catch (ServerException|ClientException  $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            throw new PrestashopWebserviceException($responseBodyAsString, $e->getCode());
        } catch (Exception) {
            throw new Exception('A global error which is undefined ?');
        }
    }

    /**
     * Define the endpoint for the request
     */
    protected function shopUrl(): ?string
    {
        return $this->shop_url != null ? $this->shop_url : config('prestashop.shop.shop_url');
    }

    private function getApiUrl(): string
    {
        return $this->shopUrl().$this->endpoint;
    }

    private function formatUrl($endpoint): string
    {
        return implode('/', [
            $this->getApiUrl(),
            $endpoint,
        ]);
    }

    /**
     * Handle basic response
     */
    protected function response(?array $response): array
    {
        $response = $response[$this->resource] ?? $response;

        if (count($response) >= 2) {
            return $response;
        }
        if (array_filter(array_keys($response), 'is_string')) {
            $firstKey = array_key_first($response);

            return $response[$firstKey];
        }
        if (count($response) == 1) {
            return $response[0];
        }

        return $response;
    }

    /**
     * Create the method for each web service resource
     *
     *
     * @return mixed
     *
     * @throws CouldNotFindResource
     */
    public function __call(string $method, array $arguments)
    {
        $method = strtolower($method);
        if (in_array(strtolower($method), self::RESOURCES)) {
            //@todo return Model instance
            $this->resource = $method;

            $class = "\LucasGiovanny\LaravelPrestashop\Resources\\".ucfirst($method);

            return new $class($this, $arguments);
        }
        throw new CouldNotFindResource();
    }

    public function pushFilter(array $array): void
    {
        $this->filters[] = $array;
    }
}
