<?php

declare(strict_types=1);

use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

App\Env::load();

$request = ServerRequestFactory::fromGlobals();
$response = (new App\Application())->process($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
