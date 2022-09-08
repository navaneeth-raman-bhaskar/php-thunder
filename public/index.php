<?php

define('APP_ROOT', dirname(__DIR__));
//ini_set('memory_limit','51M');

/**@var $app Core\Application */
$app = require_once APP_ROOT . '/bootstrap/app.php';

$router = require_once APP_ROOT . '/routes/web.php';

$app->handle(
    $router,
    new Core\Http\Request()
);


$app->run();

