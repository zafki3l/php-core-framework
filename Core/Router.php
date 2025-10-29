<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $path, mixed $callback) : void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, mixed $callback) : void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function put(string $path, mixed $callback) : void
    {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete(string $path, mixed $callback) : void
    {
        $this->routes['DELETE'][$path] = $callback;
    }
    
    public function dispatch(string $path, string $method) : void
    {
        $method = $this->overrideMethod($method);

        $result = $this->match($path, $method);

        if (!$result) {
            die('404 Page not found!');
        }

        [$callback, $params] = $result;

        if (is_array($callback)) {
            [$controller, $action] = $callback;

            $controller = App::resolve($controller);
            
            call_user_func_array([$controller, $action], $params);
            return;
        }

        call_user_func_array($callback, $params);
    }

    private function match(string $path, string $method) : mixed
    {
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);

            if (preg_match("#^$pattern$#", $path, $matches)) {
                array_shift($matches);

                return [$callback, $matches];
            }
        }

        return null;
    }

    private function overrideMethod(string $method) : string
    {
        $override = isset($_POST['_method']) ? $_POST['_method'] : null;

        if ($method === 'POST' && $override && $this->isAllowedMethod($override)) {
            return strtoupper($override);
        }

        return $method;
    }

    private function isAllowedMethod(string $override) : bool
    {
        return $override === 'PUT' || 
                $override === 'DELETE' ||
                $override === 'PATCH';
    }
}