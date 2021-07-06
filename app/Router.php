<?php

namespace App;

use App\Exceptions\MethodNotFoundException;
use App\Exceptions\ResolveRouteException;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\ViewNotFoundException;

class Router
{

    private array $routes;

    public function __construct(private Request $request)
    {
    }

    public function register(string $method, string $route, mixed $action): self
    {
        if ($route !== '' and $route[0] !== '/') {
            $route = '/'.$route;
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
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action = $this->routes[$method][$path] ?? throw new RouteNotFoundException();

        if (is_callable($action)) {
            return call_user_func($action);
        } elseif (is_array($action)) {
            [$controller, $method] = $action;
            if (method_exists($controller, $method)) {
                return call_user_func([new $controller(), $method]);
            }
            throw new MethodNotFoundException();
        } elseif (is_string($action) and file_exists(Application::VIEW_PATH.'/'.$action.'.php')) {
            return View::make($action)->render();
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

    public function view(string $route, string $view): self
    {
        $this->register('get', $route, $view);
        return $this;
    }
}