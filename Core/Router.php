<?php

namespace Core;

/**
 * Class Router
 * 
 * Handles route registration and request dispatching
 * Supports GET, POST, PUT, PATCH, DELETE HTTP methods
 */
class Router
{
    /**
     * The registered routes
     * @var array
     */
    private array $routes = [];

    /**
     * Register a GET route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function get(string $path, mixed $callback) : void
    {
        $this->routes['GET'][$path] = $callback;
    }

    /**
     * Register a POST route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function post(string $path, mixed $callback) : void
    {
        $this->routes['POST'][$path] = $callback;
    }

    /**
     * Register a PUT route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function put(string $path, mixed $callback) : void
    {
        $this->routes['PUT'][$path] = $callback;
    }

    /**
     * Register a PATCH route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function patch(string $path, mixed $callback) : void
    {
        $this->routes['PATCH'][$path] = $callback;
    }

    /**
     * Register a DELETE route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function delete(string $path, mixed $callback) : void
    {
        $this->routes['DELETE'][$path] = $callback;
    }
    
    /**
     * Dispatch the request to the matched route
     * 
     * @param string $path
     * @param string $method
     * @return void
     */
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

    /**
     * Match the given path with a registered route
     * 
     * @param string $path
     * @param string $method
     * @return array<array|mixed|null>|null
     */
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

    /**
     * Allow method override via hidden from input '_method'
     * @param string $method
     * @return string
     */
    private function overrideMethod(string $method) : string
    {
        $override = isset($_POST['_method']) ? $_POST['_method'] : null;

        if ($method === 'POST' && $override && $this->isAllowedMethod($override)) {
            return strtoupper($override);
        }

        return $method;
    }

    /**
     * Check if the override method is allowed
     * @param string $override
     * @return bool
     */
    private function isAllowedMethod(string $override) : bool
    {
        return $override === 'PUT' || 
                $override === 'DELETE' ||
                $override === 'PATCH';
    }
}