<?php

namespace LucasGiovanny\LaravelPrestashop\Persistance;

use Illuminate\Support\Collection;
use LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectToPrestashopException;
use LucasGiovanny\LaravelPrestashop\Exceptions\ResourceMissingAttributes;
use LucasGiovanny\LaravelPrestashop\Prestashop;
use LucasGiovanny\LaravelPrestashop\Resources\Model;
use LucasGiovanny\LaravelPrestashop\SimpleXMLExtended;

trait Storable
{
    /**
     * @return mixed
     */
    abstract public function exists();

    abstract protected function fill(array $attributes);

    /**
     * @param  bool  $withDeferred
     */
    abstract public function json(int $options = 0, $withDeferred = false): string;

    abstract public function connection(): Prestashop;

    abstract public function url(): string;

    /**
     * @return mixed
     */
    abstract public function primaryKeyContent();

    /**
     * @return $this
     *
     * @throws CouldNotConnectToPrestashopException
     * @throws ResourceMissingAttributes
     */
    public function save(array $options = [])
    {
        if ($this->validate()) {
            if ($this->exists()) {
                $this->fill((array) $this->update());
            } else {
                $this->fill($this->insert());
            }

            return $this;
        } else {
            throw new ResourceMissingAttributes($this->getErrors());
        }
    }

    /**
     * @return array|bool|Collection|null
     *
     * @throws CouldNotConnectToPrestashopException
     */
    private function insert()
    {
        $xml = $this->createXmlFromModel($this);

        return $this->connection()->post($this->url(), $xml);
    }

    /**
     * @throws ResourceMissingAttributes
     * @throws CouldNotConnectToPrestashopException
     */
    public function create(array $attributes)
    {
        $this->fill($attributes);
        if ($this->validate()) {
            $xml = $this->createXmlFromModel($attributes);
            if ($this->connection()->post($this->url(), $xml)) {
                return $this;
            }
        } else {
            throw new ResourceMissingAttributes($this->getErrors());
        }

        return null;
    }

    /**
     * @return array|bool|Collection|null
     *
     * @throws CouldNotConnectToPrestashopException
     */
    private function update(): array
    {
        $primaryKey = $this->primaryKeyContent();

        return $this->connection()->put($this->url().'/'.$primaryKey,
            $this->createXmlFromModel($this));
    }

    /**
     * @return Collection|null
     *
     * @throws CouldNotConnectToPrestashopException
     */
    public function delete()
    {
        $primaryKey = $this->primaryKeyContent();
        $this->connection()->destroy($this->url(), $primaryKey);
    }

    /**
     * Parse Array to Xml
     *
     * @return void
     */
    private function parseArrayToXml($data, $xml_data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (preg_match('~[0-9]+~', $key)) {
                    $new_key = preg_replace('~[0-9]+~', '', $key);
                    $key = $new_key;
                }
                $subnode = $xml_data->addChild($key);
                $this->parseArrayToXml($value, $subnode);
            } else {
                $xml_data->addChild("$key");
                $xml_data->$key->addCData($value);
            }
        }

        return $xml_data;
    }

    /**
     * Create xml from model
     *
     * @return bool|string
     */
    protected function createXmlFromModel($model)
    {
        if ($model instanceof Model) {
            $subModule = $model->xml_header;
            $xml_data = new SimpleXMLExtended('<prestashop xmlns:xlink="http://www.w3.org/1999/xlink"/>');

            //Get all fillables and fill array values with null, To later compine these
            $values = array_fill(0, count($model->getFillable()), null);
            $keys = array_combine($model->getFillable(), $values);
            $atributes = array_merge($keys, $model->attributes());

            if (isset($model->attributes()['id']) && $model->attributes()['id'] != null) {
            } else {
                unset($atributes['id']);
            }

            $array[$subModule] = $atributes;
            $this->parseArrayToXml($array, $xml_data);

            return $xml_data->asXML();
        }

        return null;
    }
}
