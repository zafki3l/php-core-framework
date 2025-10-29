<?php

namespace Core;

use ReflectionClass;

/**
 * Class Container
 * 
 * Responsible for binding and resolving class dependencies
 */
class Container
{
    /**
     * The registered bindings
     * 
     * @var array
     */
    protected array $bindings = [];

    /**
     * Bind a class or interface to a resolver callback
     * 
     * @param string $class
     * @param callable $callback
     * @return void
     */
    public function bind(string $class, callable $callback): void
    {
        $this->bindings[$class] = $callback;
    }

    /**
     * Resolve an instance of the given class.
     *
     * If a binding exists, it uses the custom resolver.
     * Otherwise, it attempts to instantiate the class automatically
     * by resolving constructor dependencies using reflection.
     * 
     * @param string $class
     * @return object
     */
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
