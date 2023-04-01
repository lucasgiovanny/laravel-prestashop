<?php

namespace LucasGiovanny\LaravelPrestashop\Query;

use LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectToPrestashopException;
use LucasGiovanny\LaravelPrestashop\Exceptions\InvalidePrestashopFilterException;
use LucasGiovanny\LaravelPrestashop\Prestashop;
use LucasGiovanny\LaravelPrestashop\Resources\Model;

trait Searchable
{
    /**
     * Append a filter to the webservice request
     *
     * @throws InvalidePrestashopFilterException
     */
    public function filter(string $field, array|string $operatorOrValue, array|string $value = null): self
    {
        $operator = $value ? $operatorOrValue : '=';

        if (! in_array(strtoupper($operator), Prestashop::FILTER_OPERATORS)) {
            throw new InvalidePrestashopFilterException;
        }

        $this->prestashop->addFilter([
            'field' => $field,
            'operator' => strtoupper($operator),
            'value' => $value ?: $operatorOrValue,
        ]);

        return $this;
    }

    /**
     * @throws InvalidePrestashopFilterException
     *
     * @see Searchable::filter()
     */
    public function where(string $field, array|string $operatorOrValue, array|string $value = null): self
    {
        return $this->filter($field, $operatorOrValue, $value);
    }

    /**
     * Execute the get request with the condition applied
     *
     * @throws CouldNotConnectToPrestashopException
     */
    public function find(int $id): Model|null
    {
        $this->prestashop->cleanFilters();

        $this->prestashop->addFilter([
            'field' => 'id',
            'operator' => '=',
            'value' => $id,
        ]);

        $this->fill($this->prestashop->get());

        return $this;
    }
}
