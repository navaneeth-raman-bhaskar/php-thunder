<?php


namespace Core\Database;


use Core\Application;
use Core\Traits\FactoryMethod;
use Generator;
use PDO;

abstract class Model
{
    use FactoryMethod;

    protected PDO $db;

    public function __construct()
    {
        $this->db = Application::instance()->db();
    }

    public static function query(): QueryBuilder
    {
        return new QueryBuilder((new static)->table, static::class);
    }

    public static function get($limit = 100000): array
    {
        $table = (new static)->table;
        return (new static)->db
            ->query("select * from $table limit $limit")
            ->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function lazy($limit = 100000): Generator
    {
        $table = (new static)->table;
        $query = (new static)->db
            ->query("select * from $table limit $limit");

        return self::fetchLazy($query);
    }


    private static function fetchLazy(\PDOStatement $query): Generator
    {
        foreach ($query as $record) {
            yield $record;
        }
    }

}