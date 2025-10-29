<?php

namespace Core;

class App
{
    protected static Container $container;

    public static function setContainer(Container $container) : void
    {
        static::$container = $container;
    }

    public static function resolve(string $class) : object
    {
        return static::container()->resolve($class);
    }

    private static function container() : Container
    {
        return static::$container;
    }
}