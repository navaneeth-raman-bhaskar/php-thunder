<?php


namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;

    private function __construct(array $config, ?array $options = null)
    {
        try {
            $defaultOptions = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            static::$instance = new PDO(
                $config['dns'],
                $config['username'],
                $config['password'],
                $options ?? $defaultOptions
            );
        } catch (PDOException $e) {
            return View::make('errors/error')->with(['message' => $e->getMessage()]);
        }
    }

    public static function instance(array $config, ?array $options = null): PDO
    {
        if (!static::$instance) {
            new static($config, $options);
        }
        return static::$instance;
    }

}