<?php

namespace Lucasgiovanny\LaravelPrestashop\Resources;

use Illuminate\Support\Facades\App;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use Lucasgiovanny\LaravelPrestashop\Persistance\Storable;
use Lucasgiovanny\LaravelPrestashop\Prestashop;
use Nette\Utils\Validators;

abstract class Model implements \JsonSerializable
{
    /**
     * @var Prestashop
     */
    protected $connection = null;
    /**
     * @var array The model's attributes
     */
    protected $attributes = [];

    /**
     * @deferred array The model's collection values
     */
    protected $deferred = [];

    /**
     * @var array The model's fillable attributes
     */
    protected $fillable = [];

    /**
     * @var string the xml header
     */
    protected $xml_header = '';
    /**
     * @var string The URL endpoint of this model
     */
    protected $url = '';

    /**
     * @var string Name of the primary key for this model
     */
    protected $primaryKey = 'id';


    /**
     * Error message bag
     *
     * @var MessageBag
     */
    protected $errors;

    /**
     * Validation rules
     *
     * @var array
     */
    protected static $rules = array();

    /**
     * Custom messages
     *
     * @var array
     */
    protected static $messages = array();
    /**
     * Validator instance
     *
     * @var Validator
     */
    protected $validator;

    /**
     * @param  Prestashop|null  $connection
     * @param $attributes
     * @param  Validator|null  $validator
     */
    public function __construct(Prestashop $connection =null, $attributes = [], Validator $validator = null)
    {
        //Set connection if there is, otherwise use Facade with default settings
        if (isset($connection)) {
            $this->connection = $connection;
        }
        $this->validator = $validator ?: App::make('validator');
        $this->fill($attributes);
    }



    /**
     * Validates current attributes against rules
     */
    public function validate(): bool
    {
        $v = $this->validator->make($this->attributes, static::$rules, static::$messages);

        if ($v->passes()) {
            return true;
        }

        $this->setErrors($v->messages());
        return false;
    }

    /**
     * Set error message bag
     *
     * @var MessageBag
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Retrieve error message bag
     */
    public function getErrors(): MessageBag
    {
        return $this->errors;
    }

    /**
     * Inverse of wasSaved
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get the connection instance.
     *
     * @return Prestashop
     */
    public function connection(): Prestashop
    {
        return $this->connection;
    }

    /**
     * Get the model's attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Get the model's url.
     *
     * @return string
     */
    public function url($id = null): string
    {
        if (isset($id)) {
            return $this->url."/".$id;
        }
        return $this->url;
    }

    /**
     * Get the model's primary key.
     *
     * @return string
     */
    public function primaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * Get the model's primary key value.
     *
     * @return mixed
     */
    public function primaryKeyContent()
    {
        return $this->__get($this->primaryKey);
    }

    /**
     * Fill the entity from an array.
     *
     * @param  array  $attributes
     */
    protected function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }

    /**
     * Get the fillable attributes of an array.
     *
     * @param  array  $attributes
     *
     * @return array
     */
    protected function fillableFromArray(array $attributes): array
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    protected function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }

    public function getFillable()
    {
        return $this->fillable;
    }

    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }


    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    public function __set($key, $value)
    {
        if ($this->isFillable($key)) {
            if (is_array($value)) {
                $this->deferred[$key] = $value;

                return;
            }

            $this->setAttribute($key, $value);
        }
    }

    public function __isset($name)
    {
        return $this->__get($name) !== null;
    }

    public function __call($name, $arguments)
    {
        return $this->__get($name);
    }

    /**
     * Refresh deferred item by clearing and then lazy loading it.
     *
     * @param  mixed  $key
     *
     * @return mixed
     */
    public function refresh($key)
    {
        unset($this->deferred[$key]);

        return $this->__get($key);
    }

    /**
     * Checks if primaryKey holds a value.
     *
     * @return bool
     */
    public function exists(): bool
    {
        if (!array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }
        return !empty($this->attributes[$this->primaryKey]);
    }

    /**
     * Return the JSON representation of the data.
     *
     * @param  int  $options  http://php.net/manual/en/json.constants.php
     *
     * @return string
     */
    public function json(int $options = 0, $withDeferred = false): string
    {
        $attributes = $this->attributes;
        if ($withDeferred) {
            foreach ($this->deferred as $attribute => $collection) {
                if (empty($collection)) {
                    continue; // Leave original array with __deferred key
                }

                $attributes[$attribute] = [];
                foreach ($collection as $value) {
                    if (!empty($value->deferred)) {
                        $value->attributes = array_merge($value->attributes, $value->deferred);
                    }

                    if (is_a($value, 'App\Services\Prestashop\Resources')) {
                        $attributes[$attribute][] = $value->attributes;
                    } else {
                        $attributes[$attribute][] = $value;
                    }
                }
            }
        }

        return json_encode($attributes, $options);
    }

    /**
     * Return serializable data.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->attributes;
    }
}
