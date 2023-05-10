<?php

use App\Controllers\AuthController;
use App\Controllers\IndexController;
use App\Services\Application;

$router = Application::$app->router;

$router->get('/', [IndexController::class, 'index']);
$router->get('/login', [IndexController::class, 'login']);
$router->post('/auth/login', [AuthController::class, 'signin']);