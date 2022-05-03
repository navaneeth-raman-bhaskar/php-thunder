<?php


namespace App\Models;


use App\Application;
use App\FactoryMethod;
use PDO;

abstract class Model
{
    use FactoryMethod;

    protected PDO $db;

    public function __construct()
    {
        $this->db = Application::instance()->db();
    }

    public static function get(): array
    {
        $table = (new static)->table;
        return (new static)->db
            ->query("select * from $table")
            ->fetchAll(PDO::FETCH_CLASS,static::class);
    }

}