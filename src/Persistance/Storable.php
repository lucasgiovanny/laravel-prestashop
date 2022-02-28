<?php

namespace Lucasgiovanny\LaravelPrestashop\Persistance;


use Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException;
use Lucasgiovanny\LaravelPrestashop\Prestashop;

trait Storable
{
    /**
     * @return mixed
     */
    abstract public function exists();

    /**
     * @param  array  $attributes
     */
    abstract protected function fill(array $attributes);

    /**
     * @param  int  $options
     * @param  bool  $withDeferred
     *
     * @return string
     */
    abstract public function json(int $options = 0, $withDeferred = false): string;

    /**
     * @return Prestashop
     */
    abstract public function connection(): Prestashop;

    /**
     * @return string
     */
    abstract public function url(): string;

    /**
     * @return mixed
     */
    abstract public function primaryKeyContent();

    /**
     * @return $this
     * @throws CouldNotConnectException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function save()
    {
        if ($this->exists()) {
            $this->fill($this->update());
        } else {
            $this->fill($this->insert());
        }
        return $this;
    }

    /**
     * @return array|mixed
     * @throws CouldNotConnectException|\GuzzleHttp\Exception\GuzzleException
     *
     */
    public function insert()
    {
        return $this->connection()->post($this->url(), $this->connection()->createXmlFromModel($this));
    }

    public function create(array $attributes){

    }

/**
 * @return array|mixed
 * @throws CouldNotConnectException
 *
 */
public
function update()
{
    $primaryKey = $this->primaryKeyContent();

    return $this->connection()->put($this->url()."/".$primaryKey,
        $this->connection()->createXmlFromModel($this->json()));
}

/**
 * @return array|mixed
 * @throws CouldNotConnectException
 *
 */
public
function delete()
{
    $primaryKey = $this->primaryKeyContent();
    return $this->connection()->destroy($this->url().'/'.$primaryKey);
}
}
