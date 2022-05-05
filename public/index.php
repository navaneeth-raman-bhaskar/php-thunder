<?php

/**@var $app App\Core\Application */
define('APP_ROOT', dirname(__DIR__));

$app = require_once APP_ROOT . '/bootstrap/app.php';

$router = require_once APP_ROOT . '/routes/web.php';

$app->handle(
    $router,
    new App\Core\Http\Request()
);


$app->run();

