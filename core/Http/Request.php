<?php


namespace Core\Http;


use Core\Traits\FactoryMethod;

class Request
{
    use FactoryMethod;

    private array $get;
    private array $post;
    private array $files;
    private array $server;

    public function __construct()
    {
        $this->get = $_GET;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->setPost();
    }

    private function setPost()
    {
        $this->post = array_merge(
            $_POST,
            json_decode(file_get_contents('php://input'), true) ?? []
        );
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
        return strtolower(
            $this->server('REQUEST_METHOD') ??
            $this->server('X-HTTP-METHOD-OVERRIDE') ??
            $this->post('__method')
        );
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

    public function isXmlHttpRequest(): bool
    {
        return 'XMLHttpRequest' === $this->server('X-Requested-With');
    }
}