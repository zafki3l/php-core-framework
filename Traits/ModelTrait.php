<?php

namespace Traits;

/**
 * Trait ModelTrait
 * 
 * Provides helper methods for Model classes
 */
trait ModelTrait
{
    /**
     * Magic getters
     * 
     * A better solution for regular getters
     * Dynamically retrieves the value of an existing property.
     * 
     * @param mixed $name
     * @return mixed
     */
    public function __get(mixed $name) : mixed
    {
        return property_exists($this, $name) ? $this->$name : null;
    }

    /**
     * Magic setters
     * 
     * A better solution for regular setters
     * Dynamically assigns a value to an existing property.
     * 
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value) : void
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    /**
     * Automatically binds associative array data to the model's properties
     * 
     * @param array $data
     * @return void
     */
    public function fill(array $data) : void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}