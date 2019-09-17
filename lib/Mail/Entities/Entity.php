<?php

namespace Xedi\SendGrid\Mail\Entities;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    protected $properties = [];

    public function __construct($attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill($attributes = [])
    {
        foreach ($attributes as $name => $value) {
            $this->properties[$name] = $value;
        }
    }

    public function __get($attribute_name)
    {
        return $this->properties[$attribute_name];
    }

    public function __set($attribute_name, $attribute_value)
    {
        return $this->properties[$attribute_name] = $attribute_value;
    }

    public function toJson(): string
    {
        return json_encode($this->properies);
    }

    public function jsonSerialize()
    {
        return $this->toJson();
    }
}
