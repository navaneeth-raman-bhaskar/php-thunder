<?php


namespace App\Core;


use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Http\Request;
use App\Core\Http\Response;
use FilesystemIterator;

class Application
{
    private static ?Application $instance = null;
    private static Container $container;
    private Router $router;
    private Request $request;
    private array $config = [];
    private array $env;

    private function __construct()
    {
        $this->env = $_ENV;
        static::$container = BindingServiceProvider::make()->register(new Container());
    }

    public static function instance(): static
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public static function getContainer(): Container
    {
        return static::$container;
    }

    public function handle(Router $router, Request $request): static
    {
        $this->router = $router;
        $this->request = $request;
        return $this;
    }

    public function setConfig(string $configPath): static
    {
        foreach (new FilesystemIterator($configPath) as $fileInfo) {
            /**@var $fileInfo \SplFileInfo */
            $config = require_once $fileInfo->getPathName();
            $this->config = array_merge($this->config, $config);
        }

        return $this;
    }

    public function getConfig(string $key)
    {
        return $this->config[$key] ?? null;
    }

    public function getEnv(string $key): ?string
    {
        return $this->env[$key] ?? null;
    }

    public function db(): \PDO
    {
        return DB::instance(config(config('default_connection')));
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request);
        } catch (RouteNotFoundException $e) {
            Response::make()
                ->setCode(404)
                ->setMessage('Given Route Not Found')
                ->buildHeader();

            echo View::make('errors/error')->with(['message' => $e->getMessage()]);
        } catch (Exceptions\MethodNotFoundException | Exceptions\ResolveRouteException | Exceptions\ViewNotFoundException $e) {
            Response::make()->setResponseCode(405);
            echo View::make('errors/error')->with(['message' => $e->getMessage()]);
        }
    }
}