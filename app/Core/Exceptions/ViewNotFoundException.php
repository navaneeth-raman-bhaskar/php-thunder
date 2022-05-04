<?php


namespace App\Core\Exceptions;


class ViewNotFoundException extends \Exception
{
    protected $message = 'The view is not found';
}