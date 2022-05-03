<?php


namespace App;


class Collection implements \IteratorAggregate
{
    public function __construct(private array $array)
    {
    }

    public static function make(array $array): static
    {
        return new static($array);
    }


    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }
}