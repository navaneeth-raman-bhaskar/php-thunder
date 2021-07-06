<?php


use App\Application;

require_once '../vendor/autoload.php';
session_start();

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
)->view('intro','welcome');

$app->run();

