<?php


namespace App\Exceptions;


class ResolveRouteException extends \Exception
{
    protected $message = 'Route cannot be resolved, check action parameter';
}