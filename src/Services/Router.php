<?php

namespace App\Services;

class Router
{
    protected Request $request;
    public View $view;
    protected array $routes = [];

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new View();
    }

    public function get(string $path, \Closure|string|array $callback): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, \Closure|string|array $callback): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve()
    {
        $method = $this->request->getHttpMethod();
        $path = $this->request->getPath();

        if (!array_key_exists($method, $this->routes)) {
            echo "Method {$method} does not exists in routes array!";

            Application::$app->response->setStatusCode(404);

            die();
        }

        if (!array_key_exists($path, $this->routes[$method])) {
            echo "Path {$path} does not exists in {$method} routes!";

            Application::$app->response->setStatusCode(404);

            die();
        }

        $callback = $this->routes[$method][$path];

        if (is_string($callback)) {
            $this->view->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request);
    }
}