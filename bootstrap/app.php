<?php

use App\Core\Application;

session_start();

require_once APP_ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();
/*set_exception_handler(
    function (\Throwable $exception) {
        var_dump('global exception-:<br>'.$exception->getMessage());
    }
);*/

$app = Application::instance();

$app->setConfig(
    APP_ROOT . '/config'
);

return $app;