<?php


namespace App\Core;

use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;

    private function __construct(array $config)
    {
        try {
            $defaultOptions = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            static::$instance = new PDO(
                $config['dns'],
                $config['username'],
                $config['password'],
                $config['options'] ?? $defaultOptions
            );
        } catch (PDOException $e) {
            return View::make('errors/error')->with(['message' => $e->getMessage()]);
        }
    }

    public static function instance(array $config): PDO
    {
        if (!static::$instance) {
            new static($config);
        }
        return static::$instance;
    }

}