<?php

namespace App;

use App\Exceptions\MethodNotFoundException;
use App\Exceptions\ResolveRouteException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\ViewNotFoundException;

class Router
{
    use FactoryMethod;

    private array $routes;

    private function register(string $method, string $route, mixed $action): self
    {
        if ($route !== '' and $route[0] !== '/') {
            $route = '/' . $route;
        }
        $this->routes[strtolower($method)][$route] = $action;
        return $this;
    }

    /**
     * @throws RouteNotFoundException
     * @throws MethodNotFoundException
     * @throws ResolveRouteException
     * @throws ViewNotFoundException
     */
    public function resolve(Request $request)
    {
        $path = $request->path();
        $method = $request->method();
        $action = $this->routes[$method][$path] ?? throw new RouteNotFoundException();

        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$controller, $method] = $action; //array destructuring

            if (method_exists($controller, $method)) {
                return call_user_func([new $controller(), $method]);
            }
            throw new MethodNotFoundException();
        }

        if (is_string($action) and file_exists(view_path($action . '.php'))) {
            return View::make($action)->render();
        }

        throw new ResolveRouteException();
    }

    public function get(string $route, array|callable $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, array|callable $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function put(string $route, array|callable $action): self
    {
        return $this->register('put', $route, $action);
    }

    public function delete(string $route, array|callable $action): self
    {
        return $this->register('delete', $route, $action);
    }

    public function view(string $route, string $view): self
    {
        return $this->register('get', $route, $view);
    }
}