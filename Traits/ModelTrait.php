<?php

namespace Traits;

trait ModelTrait
{
    public function __get(mixed $name) : mixed
    {
        return property_exists($this, $name) ? $this->$name : null;
    }

    public function __set($name, $value) : void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function fill(array $data) : void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}