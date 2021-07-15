<?php

namespace Lucasgiovanny\LaravelPrestashop\Models;

class Resource
{
    /**
     * Construct the resource model with attributes
     *
     * @param string $resource
     * @param array  $attributes
     *
     * @return void
     */
    public function __construct(public string $resource, public ?array $attributes = null)
    {
    }

    /**
     * Magic method to return attribute as property
     *
     * @param string $name
     *
     * @return void
     */
    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }
}
