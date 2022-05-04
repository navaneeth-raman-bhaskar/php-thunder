<?php


namespace App\Core\Model;


use App\Core\Application;
use App\Core\Traits\FactoryMethod;
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