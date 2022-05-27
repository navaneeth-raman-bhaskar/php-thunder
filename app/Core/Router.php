<?php

namespace App\Core;

use App\Core\Exceptions\MethodNotFoundException;
use App\Core\Exceptions\ResolveRouteException;
use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Exceptions\ViewNotFoundException;
use App\Core\Http\Request;
use App\Core\Traits\FactoryMethod;

class Router
{
    use FactoryMethod;

    private array $routes;

    public function __construct(private Container $container)
    {
    }

    private function register(string $method, string $route, mixed $action): self
    {
        if ($route === '' or $route[0] !== '/') {
            $route = '/' . $route;
        }
        $this->routes[strtolower($method)][$route] = $action;
        return $this;
    }

    /**
     * @param Request $request
     * @return false|mixed|string
     * @throws MethodNotFoundException
     * @throws ResolveRouteException
     * @throws RouteNotFoundException
     * @throws ViewNotFoundException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \ReflectionException
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
                return call_user_func([$this->container->get($controller), $method]);
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