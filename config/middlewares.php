<?php

return [
    Middlewares\ResponseTime::class,
    [
        'class' => Zend\Stratigility\Middleware\PathMiddlewareDecorator::class,
        'args' => [
            '/admin',
            $this->container->get(App\Middleware\AuthenticationMiddleware::class)
        ]
    ],
    Middlewares\AuraRouter::class,
    Middlewares\RequestHandler::class
];
