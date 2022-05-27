<?php

use Core\Application;

session_start();

require_once APP_ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(APP_ROOT);
$dotenv->load();

set_exception_handler(
    function (\Throwable $exception) {
        dd('global exception-:<br>',$exception);
    }
);

$app = Application::instance();

$app->setConfig(
    APP_ROOT . '/config'
);

return $app;