<?php


namespace App\Core\Http;


use App\Core\Traits\FactoryMethod;

class Request
{
    use FactoryMethod;

    private array $get;
    private array $post;
    private array $files;
    private array $server;
    private array $env;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->env = $_ENV;
    }

    public function input(string $key): ?string
    {
        return $this->post($key) ?? $this->get($key) ?? $this->file($key);
    }

    public function get(string $key): ?string
    {
        return $this->get[$key] ?? null;
    }

    public function post(string $key): ?string
    {
        return $this->post[$key] ?? null;
    }

    public function file(string $key): ?string
    {
        return $this->files[$key] ?? null;
    }

    public function server(string $key): ?string
    {
        return $this->server[$key] ?? null;
    }

    public function env(string $key): ?string
    {
        return $this->env[$key] ?? null;
    }

    public function path(): string
    {
        return explode('?', $this->uri())[0];
    }

    public function uri(): string
    {
        return $this->server('REQUEST_URI');
    }

    public function method(): string
    {
        return strtolower($this->post('__method') ?? $this->server('REQUEST_METHOD'));
    }

    public function is(string $method): bool
    {
        return $this->method() === strtolower($method);
    }

    public function isGet(): bool
    {
        return $this->is('get');
    }

    public function isPost(): bool
    {
        return $this->is('post');
    }
}