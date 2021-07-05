<?php


use App\Application;

require_once '../vendor/autoload.php';
session_start();

const STORAGE_PATH = __DIR__.'/../storage';
const VIEW_PATH = __DIR__.'/../views';
const UPLOAD_PATH = STORAGE_PATH.'/uploads';

/*set_exception_handler(
    function (\Throwable $exception) {
        var_dump('global exception-:<br>'.$exception->getMessage());
    }
);*/

$app = Application::make();
$app->router->register(
    'get',
    '/',
    function () {
        echo App\View::make('welcome');
    }
)->view('intro','welcome')
    ->register('get', '/index', [FormController::class, 'index'])
    ->get('/create', [FormController::class, 'create'])
    ->post('/create', [FormController::class, 'store']);


$app->run();
