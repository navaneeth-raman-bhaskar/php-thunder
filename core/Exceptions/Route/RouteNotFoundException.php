<?php


namespace Core\Exceptions;


class RouteNotFoundException extends \Exception
{
    protected $message = '404 Route Not Found';
}