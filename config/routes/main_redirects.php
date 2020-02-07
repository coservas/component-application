<?php

return [
    [
        'methods' => ['get'],
        'name' => 'redirect_into_login',
        'path' => '/login',
        'handler' => function () {
            return new \Zend\Diactoros\Response\RedirectResponse($this->router->getGenerator()->generate('app.login'));
        }
    ],
];