<?php

namespace Core\Contracts;

interface KernelContract
{
    public function handle($input, $output);

}