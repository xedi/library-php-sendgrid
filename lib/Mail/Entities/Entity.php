<?php

namespace Xedi\SendGrid\Mail\Entities;

use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Entity Abstract Class
 *
 * @package Xedi\SendGrid\Mail\Entities
 * @author  Chris Smith <chris@xedi.com>
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
     * Create an instance of a class that extends Entity
     *
     * @param array $attributes Entity attributes
     */
    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the Entity with data
     *
     * @param array $attributes Attributes to add to the class
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
     * @param string $attribute_name The name of the attribute to retrieve
     *
     * @return mixed
     */
    public function __get($attribute_name)
    {
        return $this->properties[$attribute_name];
    }

    /**
     * Magic Set
     *
     * @param string $attribute_name  The name of the attribute
     * @param mixed  $attribute_value The value to set
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
        return array_map(
            function ($property) {
                if (is_object($property) && $property instanceof Arrayable) {
                    return $property->toArray();
                }

                return $property;
            },
            $this->properties
        );
    }
}
