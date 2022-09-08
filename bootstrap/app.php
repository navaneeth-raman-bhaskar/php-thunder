<?php

use Core\Application;

session_start();

require_once APP_ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

if (env('APP_DEBUG')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    define('PDO_ERROR_LEVEL', PDO::ERRMODE_EXCEPTION);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
    define('PDO_ERROR_LEVEL', PDO::ERRMODE_SILENT);
}
/*set_exception_handler(
    function (\Throwable $exception) {
        dd('Global exception-:<br>',$exception);
    }
);*/

//set_error_handler(fn()=>dd('Handler',func_get_args()),E_ALL);

$app = Application::instance();

$app->setConfig(
    APP_ROOT . '/config'
);

return $app;