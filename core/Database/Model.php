<?php


namespace Core\Database;


use Core\Application;
use Core\Traits\FactoryMethod;
use Generator;
use PDO;

abstract class Model
{
    use FactoryMethod;

    public static function query(): QueryBuilder
    {
        return new QueryBuilder(static::getTableName(), static::class);
    }

    protected static function getTableName(): string
    {
        $model = (new static);
        if (!property_exists($model, 'table')) {
            throw new \Exception('Table property not found on model');
        }
        return $model->table;
    }
}