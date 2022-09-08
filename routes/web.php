<?php

use Core\Router;
use App\Controllers\FormController;
use Core\Support\View;

/**@var $app Core\Application */

return Router::make($app::getContainer())
    ->get('', fn() => View::make('welcome'))
    ->view('intro', 'welcome')
    ->get('list', [FormController::class, 'index'])
    ->get('create', [FormController::class, 'create'])
    ->post('create', [FormController::class, 'store'])
    ->put('create', [FormController::class, 'update']);
