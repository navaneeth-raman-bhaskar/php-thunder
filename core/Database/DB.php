<?php


namespace Core\Database;

use Core\Support\View;
use PDO;
use PDOException;

class DB
{
    private static ?PDO $instance = null;

    private function __construct(string $connection = null)
    {
        try {
            $defaultOptions = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO_ERROR_LEVEL
            ];
            $config = config('database.' . ($connection ?? config('database.default_connection')));
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

    public static function instance(string $connection = null): PDO
    {
        if (!static::$instance) {
            new static($connection);
        }
        return static::$instance;
    }

}