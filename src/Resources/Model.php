<?php

namespace LucasGiovanny\LaravelPrestashop\Resources;

use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;
use JsonSerializable;
use LucasGiovanny\LaravelPrestashop\Exceptions\CouldNotConnectToPrestashopException;
use LucasGiovanny\LaravelPrestashop\Prestashop;

abstract class Model implements JsonSerializable
{
    /**
     * The model's attributes
     */
    protected array $attributes = [];

    public function __construct(protected Prestashop $prestashop)
    {
    }

    /**
     * Get the model's attributes
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * Fill the model attributes from an array
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
     * Get the fillable attributes of an array
     */
    protected function fillableFromArray(array $attributes): array
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * Determine if the given attribute may be filled
     */
    protected function isFillable($key): bool
    {
        return in_array($key, $this->fillable);
    }

    /**
     * Set model attribute
     */
    protected function setAttribute($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Return all the registers from API
     *
     * @throws CouldNotConnectToPrestashopException
     */
    public function all(): Collection
    {
        $collection = new Collection();

        foreach ($this->prestashop->get() as $item) {
            $model = new static($this->prestashop);
            $model->fill($item);
            $collection->push($model);
        }

        return $collection;
    }

    /*!!!!!***** Refactor from here ****/

    /**
     * @deferred array The model's collection values
     */
    protected array $deferred = [];

    /**
     * @var array The model's fillable attributes
     */
    protected array $fillable = [];

    /**
     * @var string The URL endpoint of this model
     */
    protected $url;

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
    protected static $rules = [];

    /**
     * Custom messages
     *
     * @var array
     */
    protected static $messages = [];

    /**
     * Validator instance
     *
     * @var Validator
     */
    protected $validator;

    public function getRules(): array
    {
        return static::$rules;
    }

    public function getMessages(): array
    {
        return static::$messages;
    }

    public function validateAttributes(array $attributes)
    {
        $v = $this->validator->make($attributes, static::$rules, static::$messages);
        if ($v->passes()) {
            return true;
        }

        return $v->messages();
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
        return ! empty($this->errors);
    }

    /**
     * Get the connection instance.
     */
    public function connection(): Prestashop
    {
        return $this->connection;
    }

    /**
     * Get the model's url.
     */
    public function url($id = null): string
    {
        if (isset($id)) {
            return $this->url.'/'.$id;
        }

        return $this->url;
    }

    /**
     * Get the model's primary key.
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

    protected function addFillable($key)
    {
        $this->fillable[] = $key;
    }

    public function getFillable()
    {
        return $this->fillable;
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

    /**
     * Refresh deferred item by clearing and then lazy loading it.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function refresh($key)
    {
        unset($this->deferred[$key]);

        return $this->__get($key);
    }

    /**
     * Checks if primaryKey holds a value.
     */
    public function exists(): bool
    {
        if (! array_key_exists($this->primaryKey, $this->attributes)) {
            return false;
        }

        return ! empty($this->attributes[$this->primaryKey]);
    }

    /**
     * Return the JSON representation of the data.
     *
     * @param  int  $options  http://php.net/manual/en/json.constants.php
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
                    if (! empty($value->deferred)) {
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
     */
    public function jsonSerialize(): array
    {
        return $this->attributes;
    }
}
