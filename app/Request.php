<?php


namespace App;


class Request
{

    public function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public function path(): string
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0];
    }

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->method() === 'get';
    }

    public function isPost(): bool
    {
        return $this->method() === 'post';
    }
}