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
];
