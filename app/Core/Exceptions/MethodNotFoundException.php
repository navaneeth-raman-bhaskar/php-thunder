<?php


namespace App\Core\Exceptions;


class MethodNotFoundException extends \Exception
{
    protected $message = 'Method Not Found on Class';
}