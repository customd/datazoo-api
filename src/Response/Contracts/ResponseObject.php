<?php

namespace CustomD\Datazoo\Response\Contracts;

use JsonSerializable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

abstract class ResponseObject implements JsonSerializable
{
    public function __construct(array $response)
    {
        foreach ($response as $k => $v) {
            $this->setAttribute($k, $v);
        }
    }

    public function setAttribute(string $key, $value)
    {
        $method = 'set' . Str::studly($key) . 'Attribute';
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } else {
            $this->$key = $value;
        }
        return $this;
    }

    public function toArray()
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, (array) $this);
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
