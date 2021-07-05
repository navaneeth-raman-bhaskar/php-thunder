<?php


namespace App\Controllers;

use App\Models\Invoice\Invoice;
use App\Collection;
use App\View;

class FormController extends Controller
{
    public function index(): void
    {
        $invoices = [Invoice::make(22), Invoice::make(3), Invoice::make(44)];

        $invoices = Collection::make($invoices);
        var_dump('<pre>');

        foreach ($invoices as $invoice) {
            var_dump($invoice->id);
        }
        var_dump($_SESSION, $_COOKIE);
    }

    public function create(): View
    {
        return View::make('form/input_form',['placeholder'=>'Enter name']);
    }

    public function store()
    {
        $this->uploadFile();
    }

    private function uploadFile(): void
    {
        $path = UPLOAD_PATH.'/'.$_FILES['doc']['name'];
        move_uploaded_file($_FILES['doc']['tmp_name'], $path);
    }
}