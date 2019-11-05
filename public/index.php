<?php

use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$request = ServerRequestFactory::fromGlobals();
$response = (new HtmlResponse('Hello, World!'))
    ->withHeader('X-Developer', 'CoSerVas');

$emitter = new SapiEmitter();
$emitter->emit($response);