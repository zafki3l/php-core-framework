<?php

namespace Core;

use Exception;
use ReflectionClass;

class Container
{
    protected array $bindings = [];

    public function bind(string $class, callable $callback): void
    {
        $this->bindings[$class] = $callback;
    }

    public function resolve(string $class) : object
    {
        if (isset($this->bindings[$class])) {
            return $this->bindings[$class]($this);
        }
        
        $reflector = new ReflectionClass($class);

        $constructor = $reflector->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType();
            
            $dependencies[] = $this->resolve((string) $type);
        }
        
        return new $class(...$dependencies);
    }
}
