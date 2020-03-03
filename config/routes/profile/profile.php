<?php

return [
    [
        'methods' => ['get'],
        'name' => 'profile',
        'path' => '/profile',
        'handler' => App\Action\Profile\ProfileAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'change-personal-data',
        'path' => '/profile/change-personal-data',
        'handler' => App\Action\Profile\ChangePersonalDataAction::class,
    ],
];
