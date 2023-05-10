<?php

namespace App\Services;

final class Application
{
    public static Application $app;
    public static string $root_dir;
    public Router $router;
    public Response $response;
    public Database $database;

    public function __construct(string $root, array $config)
    {
        self::$root_dir = $root;

        $this->router = new Router();
        $this->response = new Response();
        $this->database = new Database();

        self::$app = $this;
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}