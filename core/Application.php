<?php


namespace Core;


use Core\Database\DB;
use Core\Exceptions\MethodNotFoundException;
use Core\Exceptions\ResolveRouteException;
use Core\Exceptions\RouteNotFoundException;
use Core\Exceptions\ViewNotFoundException;
use Core\Http\Request;
use Core\Http\Response;
use Core\Providers\BindingServiceProvider;
use Core\Support\View;
use FilesystemIterator;
use PDO;

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
        static::$container = BindingServiceProvider::make()->register($this,new Container());
    }

    public function runningInConsole(): bool
    {
        if (defined('STDIN')) {
            return true;
        }

        if (php_sapi_name() === 'cli') {
            return true;
        }

        if (empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) {
            return true;
        }

        if (!array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return true;
        }

        if (array_key_exists('SHELL', $_ENV)) {
            return true;
        }

        return false;
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
            $file = str_replace('.php','',$fileInfo->getFilename());
            $this->config[$file] = $config;
        }

        return $this;
    }

    public function getConfig(string $key):mixed
    {
        return getDotArray($key, $this->config);
    }

    public function getEnv(string $key): ?string
    {
        return $this->env[$key] ?? null;
    }

    public function db(): PDO
    {
        return DB::instance();
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
        } catch (MethodNotFoundException | ResolveRouteException | ViewNotFoundException $e) {
            Response::make()->setResponseCode(405);
            echo View::make('errors/error')->with(['message' => $e->getMessage()]);
        }
    }
}