<?php

use App\Middleware;

return [
    Middlewares\ResponseTime::class,
    Middleware\AuthenticationMiddleware::class,
    Middlewares\AuraRouter::class,
    Middlewares\RequestHandler::class
];
