<?php

namespace App;

use App\Exceptions\MethodNotFoundException;
use App\Exceptions\ResolveRouteException;
use App\Exceptions\RouteNotFoundException;

class Router
{

    private array $routes;

    public function register(string $method, string $route, callable|array $action): self
    {
        $this->routes[strtolower($method)][$route] = $action;
        return $this;
    }

    /**
     * @throws RouteNotFoundException
     * @throws MethodNotFoundException
     * @throws ResolveRouteException
     */
    public function resolve(string $requestUrl, string $method)
    {
        $route = explode('?', $requestUrl)[0];
        $action = $this->routes[strtolower($method)][$route] ?? throw new RouteNotFoundException();
        if (is_callable($action)) {
            return call_user_func($action);
        } elseif (is_array($action)) {
            [$controller, $method] = $action;
            if (method_exists($controller, $method)) {
                return (new $controller())->$method();
            }
            throw new MethodNotFoundException();
        }
        throw new ResolveRouteException();
    }

    public function get(string $route, array|callable $action): self
    {
        $this->register('get', $route, $action);
        return $this;
    }

    public function post(string $route, array|callable $action): self
    {
        $this->register('post', $route, $action);
        return $this;
    }

    public function put(string $route, array|callable $action): self
    {
        $this->register('put', $route, $action);
        return $this;
    }

    public function delete(string $route, array|callable $action): self
    {
        $this->register('delete', $route, $action);
        return $this;
    }
}