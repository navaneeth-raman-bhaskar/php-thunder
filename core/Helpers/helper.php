<?php


use Core\Application;

const PUBLIC_PATH = APP_ROOT . '/public';
const STORAGE_PATH = APP_ROOT . '/storage';
const VIEW_PATH = APP_ROOT . '/views';
const UPLOAD_PATH = STORAGE_PATH . '/uploads';

function public_path(string $path = ''): string
{
    return PUBLIC_PATH . '/' . $path;
}
function storage_path(string $path = ''): string
{
    return STORAGE_PATH . '/' . $path;
}

function view_path(string $path = ''): string
{
    return VIEW_PATH . '/' . $path;
}

function upload_path(string $path = ''): string
{
    return UPLOAD_PATH . '/' . $path;
}

function env(string $key, $default = null): ?string
{
    return app()->getEnv($key) ?? $default;
}

function config(string $key, $default = null)
{
    return app()->getConfig($key) ?? $default;
}


function app(): Application
{
    return Application::instance();
}

/**
 * @throws \Psr\Container\ContainerExceptionInterface
 * @throws \Psr\Container\NotFoundExceptionInterface
 */
function resolve(string $class)
{
    return app()::getContainer()->get($class);
}

function dd(...$params)
{
    header('Content-Type:text/html');
    echo '<div style="width: 80%;margin:auto; color: wheat; background-color: black"><pre>';
    var_dump(...$params);
    //var_export(...$params);
    // print_r(...$params);
    echo '</pre></div>';
    die();
}

function getDotArray(string $key, array $array, $default = null): mixed
{
    $split = explode('.', $key);
    foreach ($split as $k) {
        if (isset($array[$k])) {
            $array = $array[$k];
        } else {
            $array = $default;
            break;
        }
    }
    return $array;
}