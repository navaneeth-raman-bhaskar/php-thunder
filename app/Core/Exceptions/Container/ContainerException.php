<?php


namespace App\Core;


use Exception;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends Exception implements ContainerExceptionInterface
{
    private static function make(...$params): static
    {
        return new static(...$params);
    }

    public static function noTypeHint(string $class, string $param): static
    {
        return static::make("Cannot resolve the class $class. $param has no type hint");
    }

    public static function noBinding(string $class): static
    {
        return static::make("$class has no binding registered");
    }

    public static function unionTypeNotSupported(string $class, string $param): static
    {
        return static::make("Cannot resolve the class $class. $param has union type");
    }

    public static function invalidParam(string $class, string $param): static
    {
        return static::make("Cannot resolve the class $class. has invalid $param");
    }
}