<?php

return [
    Middlewares\ResponseTime::class,
    \App\Middleware\AuthenticationMiddleware::class,
    Middlewares\AuraRouter::class,
    Middlewares\RequestHandler::class
];
