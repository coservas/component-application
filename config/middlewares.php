<?php

use App\Middleware;

return [
    Middlewares\ResponseTime::class,
    Middleware\AuthenticationMiddleware::class,
    Middleware\LanguageMiddleware::class,
    Middlewares\AuraRouter::class,
    Middlewares\RequestHandler::class
];
