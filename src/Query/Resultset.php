<?php

namespace LucasGiovanny\LaravelPrestashop\Query;

use LucasGiovanny\LaravelPrestashop\Prestashop;

class Resultset
{
    protected Prestashop $connection;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var array
     */
    protected $params;

    /**
     * Resultset constructor.
     */
    public function __construct(Prestashop $connection, string $url, string $class, array $params)
    {
        $this->connection = $connection;
        $this->url = $url;
        $this->class = $class;
        $this->params = $params;
    }

    protected function collectionFromResult(array $result): \Illuminate\Support\Collection
    {
        // If we have one result which is not an assoc array, make it the first element of an array for the
        // collectionFromResult function so we always return a collection from filter
//        if ((bool)count(array_filter(array_keys($result), 'is_string'))) {
//            $result = $result[max(array_keys($result))];
//        }
        $class = $this->class;
        $collection = [];
        foreach ($result as $r) {
            $collection[] = new $class($this->connection, $r);
        }

        return collect($collection);
    }
}
