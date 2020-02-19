<?php

return [
    [
        'methods' => ['get'],
        'name' => 'profile',
        'path' => '/profile',
        'handler' => App\Action\ProfileAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'login',
        'path' => '/login',
        'handler' => App\Action\Auth\LoginAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'register',
        'path' => '/register',
        'handler' => App\Action\Auth\RegisterAction::class,
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
        'handler' => App\Action\Auth\CheckLoginAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'check-register',
        'path' => '/check-register',
        'handler' => App\Action\Auth\CheckRegisterAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'register-completed',
        'path' => '/register-completed',
        'handler' => App\Action\Auth\RegisterCompletedAction::class,
    ],
];
