<?php


namespace App;


use App\Exceptions\RouteNotFoundException;

class Application
{

    public const ROOT = __DIR__.'/..';
    public const STORAGE_PATH = __DIR__.'/../storage';
    public const VIEW_PATH = __DIR__.'/../views';
    public const UPLOAD_PATH = __DIR__.'/../storage/uploads';

    public Router $router;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public static function make(): self
    {
        return new self();
    }


    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (RouteNotFoundException $e) {
            Response::make()
                ->setCode(404)
                ->setMessage('Given Route Not Found')
                ->buildHeader();

            echo View::make('errors/404');
        } catch (Exceptions\MethodNotFoundException | Exceptions\ResolveRouteException | Exceptions\ViewNotFoundException $e) {
            Response::make()->setResponseCode(405);
            echo View::make('errors/error')->with(['message' => $e->getMessage()]);
        }
    }
}