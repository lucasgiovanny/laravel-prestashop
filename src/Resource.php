<?php

namespace Lucasgiovanny\LaravelPrestashop;

class Resource
{
    /**
     * Resource name
     *
     * @var string
     */
    public $resource;

    /**
     * Construct the resource model with attributes
     * 
     * @param array $attributes 
     * 
     * @return void
     */
    public function __construct(public array $attributes)
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
