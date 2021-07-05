<?php


namespace App;


class Collection implements \IteratorAggregate
{
    public function __construct(private array $array)
    {
    }

    public static function make(array $array): self
    {
        return new self($array);
    }


    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }
}