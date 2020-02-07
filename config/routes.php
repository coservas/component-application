<?php

return [
    [
        'methods' => ['get'],
        'name' => 'main',
        'path' => '/',
        'handler' => App\Action\MainAction::class,
    ],
    [
        'name_prefix' => 'app.',
        'path_prefix' => '/{lang}',
        'tokens' => ['lang' => '(ru|en)'],
        'defaults' => ['lang' => 'en'],
        'routes' => require 'routes/language-dependent-routes.php',
    ],
    ... require 'routes/main_redirects.php'
];
