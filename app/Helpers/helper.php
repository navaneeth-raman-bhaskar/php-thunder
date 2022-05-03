<?php


const STORAGE_PATH = APP_ROOT . '/storage';
const VIEW_PATH = APP_ROOT . '/views';
const UPLOAD_PATH = STORAGE_PATH . '/uploads';

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

function env($key, $default = null)
{
    return \App\Application::instance()->getEnv($key) ?? $default;
}

function dd(...$params)
{
    header('Content-Type:text/html');
    echo '<div style="width: 80%;margin:auto; color: wheat; background-color: black"><pre>';
    //var_dump(...$params);
    var_export(...$params);
    // print_r(...$params);
    echo '</pre></div>';
    die();
}