<?php

namespace App\Models\Invoice;

use App\Models\Model;

class Invoice extends Model
{
    public string $public = 'public';
    public array $array = ['array1', 'array2'];
    private string $private = 'private';

    public function __construct(public int $id)
    {
    }

    public static function make(int $id): self
    {
        return new self($id);
    }

}