<?php


namespace Core\Traits;


trait FactoryMethod
{

    public static function make(...$prams): static
    {
        return new static(...$prams);
    }

}