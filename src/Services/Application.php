<?php

namespace App\Services;

final class Application
{
    public static Application $app;
    public static string $root_dir;
    public static string $view_dir;

    public Router $router;
    public Response $response;
    public Database $database;
    public Session $session;

    public function __construct(string $root, array $config)
    {
        self::$root_dir = $root;
        self::$view_dir = $root . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR;

        $this->router = new Router();
        $this->response = new Response();
        $this->database = new Database();
        $this->session = new Session();

        self::$app = $this;
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}
