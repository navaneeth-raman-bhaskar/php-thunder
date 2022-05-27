<?php


namespace Core\Exceptions;


class MethodNotFoundException extends \Exception
{
    protected $message = 'Method Not Found on Class';
}