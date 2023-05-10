<?php

namespace App\Controllers;

use App\Services\Application;
use App\Services\Session;

class Controller
{
    public function render($view, array $data = []): string
    {
        return Application::$app->router->view->renderView($view, $data);
    }
}
