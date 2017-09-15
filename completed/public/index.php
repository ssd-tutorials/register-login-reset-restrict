<?php

require_once "../bootstrap/autoload.php";

use App\Utilities\Guard;
use App\Utilities\Kernel;
use App\Utilities\Mail\MailManager;
use App\Utilities\Event\EventDispatcher;

use Illuminate\Http\Request;
use Illuminate\Container\Container;

$container = new Container;
$container->instance('request', Request::capture());
$container->instance('guard', new Guard);
$container->instance('event', new EventDispatcher);
$container->bind('mail', function() {
    return MailManager::make();
});

$app = new Kernel($container);

$views = realpath(__DIR__ . '/../resources/views');
$cache = realpath(__DIR__ . '/../resources/cache');

echo $app->make($views, $cache)->render();