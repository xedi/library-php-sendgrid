<?php

namespace Xedi\SendGrid\Mail\Entities;

use JsonSerializable;
use Xedi\SendGrid\Support\Arrayable;

/**
 * Entity Abstract Class
 * @package Xedi\SendGrid\Mail\Entities
 */
abstract class Entity implements JsonSerializable, Arrayable
{
    /**
     * Properties of the Entity
     *
     * @var array
     */
    protected $properties = [];

    /**
     * @param array $attributes Entity attributes
     */
    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the Entity with data
     *
     * @param  array  $attributes
     *
     * @return void
     */
    public function fill($attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->properties[$name] = $value;
        }
    }

    /**
     * Magic Get
     *
     * @param  string $attribute_name
     * @return mixed
     */
    public function __get($attribute_name)
    {
        return $this->properties[$attribute_name];
    }

    /**
     * Magic Set
     *
     * @param string $attribute_name
     * @param mixed $attribute_value
     *
     * @return void
     */
    public function __set($attribute_name, $attribute_value)
    {
        $this->properties[$attribute_name] = $attribute_value;
    }

    /**
     * Get the instance as an JSON string
     *
     * @return string JSON String
     */
    public function toJson(): string
    {
        return json_encode($this->properies);
    }

    /**
     * Serialize to JSON
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toJson();
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_map($this->properties, function ($property) {
            if (is_object($property) && $property instanceof Arrayable) {
                return $property->toArray();
            }

            return $property;
        });
    }
}
