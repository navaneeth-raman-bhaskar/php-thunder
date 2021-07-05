<?php


use App\Exceptions\RouteNotFoundException;
use App\Router;

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

$router = new Router();

$router->register('get', '/', function () {
    echo \App\View::make('welcome');
});


try {
    echo $router->resolve($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouteNotFoundException $e) {
    //header('HTTP/1.1 404 Not Found');
    http_response_code(404);
    echo \App\View::make('errors/404');
}
