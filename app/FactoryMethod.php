<?php


namespace App;


trait FactoryMethod
{

    public static function make(...$prams): static
    {
        return new static(...$prams);
    }

}