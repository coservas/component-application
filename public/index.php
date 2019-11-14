<?php

use App\ActionResolver;
use App\Action\LoginAction;
use App\Middleware\ProfilerMiddleware;
use Aura\Router\RouterContainer;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use Zend\Stratigility\MiddlewarePipe;

use function Zend\Stratigility\middleware;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/// Init
$app = new MiddlewarePipe();
$app->pipe(new ProfilerMiddleware());
$app->pipe(new \Middlewares\ResponseTime());

$routeContainer = new RouterContainer();
$map = $routeContainer->getMap();

$map->get('home', '/', '');
$map->get('login', '/login', LoginAction::class);
$map->get('register', '/register', '');
$map->get('reset-password', '/reset-password', '');
$map->get('profile', '/profile', '');

/// Running
$request = ServerRequestFactory::fromGlobals();

try {
    $mather = $routeContainer->getMatcher();
    $route = $mather->match($request);
} catch (Exception $e) {

}


$response = $app->process($request, new $route->handler());

$emitter = new SapiEmitter();
$emitter->emit($response);