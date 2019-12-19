<?php

use App\Service\Auth\AuthenticationAdapter;
use App\Service\Translator\MessagesLoaderInterface;
use App\Service\Translator\PhpMessagesLoader;
use App\Service\Translator\TranslatorFactory;
use App\Service\Translator\TranslatorInterface;
use App\Service\Twig\TwigExtension;
use Doctrine\ORM\EntityManagerInterface;
use ContainerInteropDoctrine\EntityManagerFactory;
use Twig\Environment;
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

    EntityManagerInterface::class => fn(): EntityManagerInterface
        => (new EntityManagerFactory())($this->container),

    MessagesLoaderInterface::class => PhpMessagesLoader::class,
    TranslatorInterface::class => fn(): TranslatorInterface
        => (new TranslatorFactory())($this->container->get(MessagesLoaderInterface::class)),

    Environment::class => fn(): Environment
        => (new TwigExtension())($this->container)
];
