<?php

use App\Controllers\AuthController;
use App\Controllers\IndexController;
use App\Controllers\ValuteController;
use App\Services\Application;

$router = Application::$app->router;

$router->get('/', [IndexController::class, 'index']);

$router->get('/signin', [IndexController::class, 'signin']);
$router->get('/signup', [IndexController::class, 'signup']);
$router->get('/auth/logout', [AuthController::class, 'logout']);

$router->post('/auth/signin', [AuthController::class, 'signin']);
$router->post('/auth/signup', [AuthController::class, 'signup']);

$router->get('/valutes/parse', [ValuteController::class, 'update']);
$router->post('/valutes/convert', [ValuteController::class, 'convert']);
