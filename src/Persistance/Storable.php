<?php

namespace Lucasgiovanny\LaravelPrestashop\Persistance;


use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotConnectException;
use Lucasgiovanny\LaravelPrestashop\Exceptions\CouldNotPost;
use Lucasgiovanny\LaravelPrestashop\Exceptions\ResourceMissingAttributes;
use Lucasgiovanny\LaravelPrestashop\Prestashop;
use Lucasgiovanny\LaravelPrestashop\Resources\Model;
use Lucasgiovanny\LaravelPrestashop\SimpleXMLExtended;
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
     * @throws ResourceMissingAttributes
     *
     */
    public function save(array $options = [])
    {
        if ($this->validate()) {
            if ($this->exists()) {
                $this->fill((array)$this->update());
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
     * @throws CouldNotConnectException
     */
    private function insert()
    {
        $xml = $this->createXmlFromModel($this);
        return $this->connection()->post($this->url(), $xml);
    }

    /**
     * @throws ResourceMissingAttributes
     * @throws CouldNotConnectException
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
     * @throws CouldNotConnectException
     *
     */
    private function update(): array
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
    public function delete()
    {
        $primaryKey = $this->primaryKeyContent();
        $this->connection()->destroy($this->url(),$primaryKey);

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
                $xml_data->addChild("$key");
                $xml_data->$key->addCData($value);
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
            $subModule = $model->xml_header;
            $xml_data = new SimpleXMLExtended('<prestashop xmlns:xlink="http://www.w3.org/1999/xlink"/>');

            //Get all fillables and fill array values with null, To later compine these
            $values = array_fill(0, count($model->getFillable()), null);
            $keys = array_combine($model->getFillable(), $values);
            $atributes = array_merge($keys, $model->attributes());
            if (isset($model->attributes()['id']) && $model->attributes()['id'] == null) {
                unset($atributes["id"]);
            }


            $array[$subModule] = $atributes;
            $this->parseArrayToXml($array, $xml_data);
            return $xml_data->asXML();
        }
        return null;
    }
}
