<?php

namespace Lucasgiovanny\LaravelPrestashop\Persistance;


use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException;
use Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotPost;
use Lucasgiovanny\LaravelPrestashop\Exceptions\ResourceMissingAttributes;
use Lucasgiovanny\LaravelPrestashop\Exceptions\ResourceNotValidated;
use Lucasgiovanny\LaravelPrestashop\Prestashop;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;
use SimpleXMLElement;

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
     * @throws GuzzleException
     *
     */
    public function save(array $options = []): static
    {
        if ($this->validate()) {
            if ($this->exists()) {
                $this->fill((array)$this->update());
            } else {
                $this->fill((array)$this->insert());
            }
        } else {
            throw new ResourceMissingAttributes($this->getErrors());
        }

        return $this;
    }

    /**
     * @return Collection
     * @throws CouldNotConnectException
     *
     */
    public function insert(): Collection
    {
        $xml = $this->createXmlFromModel($this);
        return $this->connection()->post($this->url(), $xml);
    }

    /**
     * @throws ResourceMissingAttributes
     * @throws CouldNotConnectException
     */
    public function create(array $attributes): Collection
    {
        if ($this->validate()) {
            $this->fill($attributes);
            $xml = $this->createXmlFromModel($this);
            return $this->connection()->post($this->url(), $xml);
        } else {
            throw new ResourceMissingAttributes($this->getErrors());
        }
    }

    /**
     * @return Collection
     * @throws CouldNotConnectException
     *
     */
    public function update(): Collection
    {
        $primaryKey = $this->primaryKeyContent();

        return $this->connection()->put($this->url()."/".$primaryKey,
            $this->createXmlFromModel($this));
    }

    /**
     * @return Collection|null
     * @throws CouldNotConnectException
     *
     */
    public function delete(): ?Collection
    {
        $primaryKey = $this->primaryKeyContent();
        return $this->connection()->destroy($this->url().'/'.$primaryKey);
    }

    /**
     * Parse Array to Xml
     * @param $data
     * @param $xml_data
     * @return void
     */
    private function parseArrayToXml($data, $xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
//                if (!is_numeric($key)) {
//                  //  $key = 'item'.$key; //dealing with <0/>..<n/> issues
//                }
                $subnode = $xml_data->addChild($key);
                $this->parseArrayToXml($value, $subnode);
            } else {
                $xml_data->addChild("$key", htmlspecialchars("$value"));
            }
        }
        return $xml_data;
    }

    /**
     * Create xml from model
     * @param $model
     * @return bool|string
     */
    protected function createXmlFromModel($model)
    {

        if ($model instanceof Model) {
            $subModule = $model->url;
            $xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><prestashop xmlns:xlink="http://www.w3.org/1999/xlink"></prestashop>');
            $array[$subModule] = $model->attributes();
            $this->parseArrayToXml($array, $xml_data);
            return $xml_data->asXML();
        }
        return null;
    }
}
