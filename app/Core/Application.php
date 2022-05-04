<?php


namespace App\Core;


use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Http\Request;
use App\Core\Http\Response;

class Application
{
    private static ?Application $instance = null;
    private Router $router;
    private Request $request;
    private array $config;

    private function __construct()
    {
    }

    public static function instance(): static
    {
        if (!static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function handle(Router $router, Request $request): static
    {
        $this->router = $router;
        $this->request = $request;
        return $this;
    }

    public function setConfig(array $config): static
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig(string $key): ?array
    {
        return $this->config[$key] ?? null;
    }

    public function getEnv(string $key): ?string
    {
        return $this->request->env($key);
    }

    public function db(): \PDO
    {
      return  DB::instance($this->getConfig(env('DB_CONNECTION')), null);
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