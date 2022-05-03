<?php

use App\Router;

return Router::make()
    ->get('/', fn() => App\View::make('welcome'))
    ->view('intro', 'welcome')
    ->get('list', [App\Controllers\FormController::class, 'index'])
    ->get('create', [App\Controllers\FormController::class, 'create'])
    ->post('create', [App\Controllers\FormController::class, 'store'])
    ->put('create', [App\Controllers\FormController::class, 'update']);
