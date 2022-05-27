<?php


namespace Core\Traits;


use Core\Http\Response;

trait HasJsonResponse
{
    protected function sendJsonResponse($data = [], $message = 'Success', $statusCode = 200, $headers = 'Content-Type:application/json'): Response
    {
        return Response::make()
            ->setCode($statusCode)
            ->setData($data)
            ->setMessage($message)
            ->setHeader($headers);
    }
}