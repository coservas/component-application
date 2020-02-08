<?php

use Aura\Router\Generator;
use Zend\Diactoros\Response\RedirectResponse;

/** @var Generator $generator */
$generator = $this->container->get(Generator::class);

return [
    [
        'methods' => ['get'],
        'name' => 'redirect_into_login',
        'path' => '/login',
        'handler' => fn (): RedirectResponse
            => new RedirectResponse($generator->generate('login')),
    ],
    [
        'methods' => ['get'],
        'name' => 'redirect_into_register',
        'path' => '/register',
        'handler' => fn (): RedirectResponse
            => new RedirectResponse($generator->generate('register')),
    ],
];
