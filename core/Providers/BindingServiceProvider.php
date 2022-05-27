<?php


namespace Core\Providers;


use Core\Application;
use Core\Cli\Kernel as CliKernel;
use Core\Container;
use Core\Contracts\KernelContract;
use Core\Http\Kernel as HttpKernel;
use Core\Traits\FactoryMethod;

class BindingServiceProvider
{
    use FactoryMethod;

    public function register(Application $app, Container $container): Container
    {
        return $container
            ->set(KernelContract::class, function (Container $c) use ($app) {
                return $app->runningInConsole() ? new CliKernel() : new HttpKernel();
            });
    }

}