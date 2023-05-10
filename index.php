<?php

const DEBUG = true;

use App\Services\Application;

require_once './vendor/autoload.php';

$config = [];
$root = $_SERVER['DOCUMENT_ROOT'] . '/src';

$app = new Application($root, $config);

require_once 'src/Routes/web.php';

$app->run();