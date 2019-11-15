<?php declare(strict_types=1);

use App\Action\LoginAction;
use App\Action\NotFoundAction;
use Aura\Router\RouterContainer;

use League\Container\Container;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Stratigility\MiddlewarePipe;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$config = [
    'db' => [
        'user' => 'db_user',
        'pass' => 'db_pass',
    ],
];

// Container
$container = new Container();
$container->add(LoginAction::class)->addArgument(new NotFoundAction());

// Router
$router = new RouterContainer();
$map = $router->getMap();

$map->get('home', '/', '');
$map->get('login', '/login', $container->get(LoginAction::class));
$map->get('register', '/register', '');
$map->get('reset-password', '/reset-password', '');
$map->get('profile', '/profile', '');

// Pipeline
$app = new MiddlewarePipe();
$app->pipe(new Middlewares\ResponseTime());
$app->pipe(new Middlewares\AuraRouter($router));
$app->pipe(new Middlewares\RequestHandler());

/// Running
$request = ServerRequestFactory::fromGlobals();
$response = $app->process($request, new NotFoundAction());

$emitter = new SapiEmitter();
$emitter->emit($response);