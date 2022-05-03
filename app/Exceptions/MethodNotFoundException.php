<?php


namespace App\Exceptions;


class MethodNotFoundException extends \Exception
{
    protected $message = 'Method Not Found on Class';
}