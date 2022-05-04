<?php
declare(strict_types=1);

/**@var $app App\Core\Application */
define('APP_ROOT', dirname(__DIR__));

$app = require_once APP_ROOT . '/bootstrap/app.php';

$router = require_once APP_ROOT . '/routes/web.php';

$app->handle(
    $router,
    new App\Core\Request()
);

$config = require_once APP_ROOT . '/config/database.php';

$app->setConfig(
    $config
);

$app->run();

