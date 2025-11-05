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
    private array $routes = [];
    private array $middlewares = [];

    public function middleware(array $middlewares): self
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * Register a GET route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function get(string $path, mixed $action): void
    {
        $this->add('GET', $path, $action);
    }

    /**
     * Register a POST route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function post(string $path, mixed $action): void
    {
        $this->add('POST', $path, $action);
    }

    /**
     * Register a PUT route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function put(string $path, mixed $action): void
    {
        $this->add('PUT', $path, $action);
    }

    /**
     * Register a PATCH route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function patch(string $path, mixed $action): void
    {
        $this->add('PATCH', $path, $action);
    }

    /**
     * Register a DELETE route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function delete(string $path, mixed $action): void
    {
        $this->add('DELETE', $path, $action);
    }

    private function add(string $method, string $path, mixed $action): void
    {
        $this->routes[$method][$path] = [
            'action' => $action,
            'middlewares' => $this->middlewares
        ];

        $this->middlewares = [];
    }

    /**
     * Dispatch the request to the matched route
     * 
     * @param string $path
     * @param string $method
     * @return void
     */
    public function dispatch(string $path, string $method): void
    {
        // Override PUT/PATCH and DELETE method
        $method = $this->overrideMethod($method);

        $result = $this->match($path, $method);

        if (!$result) {
            die('404 Page not found!');
        }

        [$route, $params] = $result;

        $middlewares = $route['middlewares']; 
        if (!empty($middlewares)) {
            foreach ($middlewares as $middlwareClass) {
                $middleware = new $middlwareClass();
                $middleware->handle();
            }
        }

        $action = $route['action'];
        if (is_array($action)) {
            [$controller, $action] = $action;

            $controller = App::resolve($controller);

            call_user_func_array([$controller, $action], $params);
            return;
        }

        call_user_func_array($action, $params);
    }

    /**
     * Match the given path with a registered route
     * 
     * @param string $path
     * @param string $method
     * @return array<array|mixed|null>|null
     */
    private function match(string $path, string $method): mixed
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
    private function overrideMethod(string $method): string
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
    private function isAllowedMethod(string $override): bool
    {
        return $override === 'PUT' || $override === 'DELETE' || $override === 'PATCH';
    }
}
