<?php

use App\Controllers\AuthController;
use App\Controllers\IndexController;
use App\Services\Application;

$router = Application::$app->router;

$router->get('/', [IndexController::class, 'index']);

$router->get('/signin', [IndexController::class, 'signin']);
$router->get('/signup', [IndexController::class, 'signup']);

$router->post('/auth/signin', [AuthController::class, 'signin']);
$router->post('/auth/signup', [AuthController::class, 'signup']);
