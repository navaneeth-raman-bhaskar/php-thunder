<?php


namespace App\Core;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    private array $bindings = [];

    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            $binding = $this->bindings[$id];
            if (is_callable($binding)) {
                return $binding($this);
            }
            $id = $binding;
        }

        return $this->autoWire($id);

    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }

    public function set(string $id, callable|string $binding): static
    {
        $this->bindings[$id] = $binding;
        return $this;
    }

    /**
     * @throws \ReflectionException
     * @throws ContainerExceptionInterface
     */
    private function autoWire(string $class)
    {
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class;
        }

        $params = $constructor->getParameters();

        if (!$params) {
            return new $class;
        }

        $dependencies = array_map(function (\ReflectionParameter $param) use ($class) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw ContainerException::noTypeHint($class, $name);
            }
            if ($type instanceof \ReflectionUnionType) {
                throw ContainerException::unionTypeNotSupported($class, $name);
            }
            if ($type instanceof \ReflectionNamedType and !$type->isBuiltin()) {
                return $this->get($type->getName());
            }
            throw ContainerException::invalidParam($class, $name);

        }, $params);

        return $reflection->newInstanceArgs($dependencies);

    }

}