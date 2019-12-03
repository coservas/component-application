<?php

use App\Service\Auth\AuthenticationAdapter;

use Twig\Loader\LoaderInterface;
use Twig\Loader\FilesystemLoader;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\AdapterInterface;

use Zend\Session\SessionManager;
use Zend\Session\ManagerInterface;

use Zend\Session\Storage\SessionStorage;
use Zend\Session\Storage\StorageInterface;

return [
    LoaderInterface::class => [
        'class' => FilesystemLoader::class,
        'args' => [
            'templates'
        ]
    ],

    StorageInterface::class => SessionStorage::class,
    ManagerInterface::class => SessionManager::class,

    AdapterInterface::class => AuthenticationAdapter::class,
    AuthenticationService::class => AuthenticationService::class,
];