<?php

return [
    [
        'methods' => ['get'],
        'name' => 'login',
        'path' => '/login',
        'handler' => App\Action\LoginAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'admin',
        'path' => '/admin',
        'handler' => App\Action\AdminAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'check-login',
        'path' => '/check-login',
        'handler' => App\Action\CheckLoginAction::class,
    ],
];
