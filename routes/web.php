<?php

use App\Core\Router;

return Router::make()
    ->get('/', fn() => App\Core\View::make('welcome'));
