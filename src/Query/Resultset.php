<?php

namespace LucasGiovanny\LaravelPrestashop\Query;

use LucasGiovanny\LaravelPrestashop\Prestashop;

class Resultset
{
    protected Prestashop $connection;

    protected string $url;

    protected string $class;

    protected array $params;

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
}
