<?php

require_once(realpath(__DIR__ . "/../vendor/autoload.php"));

use SSD\DotEnv\DotEnv;
use App\Utilities\Session\SessionManager;

SessionManager::start();

$dotenv = new DotEnv(realpath(__DIR__ . "/../.env"));
$dotenv->overload();
$dotenv->required([
    'DB_CONNECTION',
    'SESSION_DRIVER',
    'DB_HOST',
    'DB_DATABASE',
    'DB_USERNAME',
    'DB_PASSWORD'
]);