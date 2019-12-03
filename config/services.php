<?php

use App\Service\Auth\AuthenticationAdapter;

use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

use Zend\Authentication\Adapter\AdapterInterface;

use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;
use Zend\Session\ManagerInterface;

use Zend\Session\Storage\SessionStorage;
use Zend\Session\Storage\StorageInterface;

$session = [
    StorageInterface::class => new SessionStorage(),
    ManagerInterface::class => new SessionManager(),
];

$auth = [
    AdapterInterface::class => new AuthenticationAdapter(),
];

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