<?php

return [
    'mysql' => [
        'dns' => 'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD')
    ]
];