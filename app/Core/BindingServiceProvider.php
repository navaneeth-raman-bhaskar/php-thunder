<?php


namespace App\Core;


use App\Core\Model\Model;
use App\Core\Traits\FactoryMethod;
use App\Models\User;

class BindingServiceProvider
{
    use FactoryMethod;

    public function register(Container $container): Container
    {
        return $container
            ->set(Model::class, function (Container $c) {
                return new User();
            });
    }

}