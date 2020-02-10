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
use Zend\Authentication\Storage\Session;
use Zend\Session\ManagerInterface;
use Zend\Session\SessionManager;
use Zend\Session\Storage\StorageInterface;

return [
    LoaderInterface::class => [
        'class' => FilesystemLoader::class,
        'args' => [
            'templates'
        ]
    ],

    ManagerInterface::class => SessionManager::class,
    StorageInterface::class => Session::class,

    AdapterInterface::class => AuthenticationAdapter::class,
    AuthenticationService::class => AuthenticationService::class,

    EntityManagerInterface::class => fn(): EntityManagerInterface
        => $this->container->get(EntityManagerFactory::class)($this->container),

    MessagesLoaderInterface::class => PhpMessagesLoader::class,
    TranslatorInterface::class => fn(): TranslatorInterface
        => $this->container->get(TranslatorFactory::class)(),

    Environment::class => fn(): Environment
        => $this->container->get(TwigExtension::class)(),
];
