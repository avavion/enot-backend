<?php

const DEBUG = true;

use App\Services\Application;

require_once './vendor/autoload.php';

$config = [
    "database" => [
        'dsn' => "mysql:host=localhost;dbname=enot;port=3306;charset=utf8;",
        'username' => 'root',
        'password' => ''
    ]
];
$root = $_SERVER['DOCUMENT_ROOT'] . '/src';

$app = new Application($root, $config);

require_once 'src/Routes/web.php';

$app->run();
