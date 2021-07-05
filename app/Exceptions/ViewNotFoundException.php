<?php


namespace App\Exceptions;


class ViewNotFoundException extends \Exception
{
    protected $message = 'The view is not found';
}