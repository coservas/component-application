<?php

use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

use Zend\Session\ManagerInterface;
use Zend\Session\SessionManager;

return [
    LoaderInterface::class => new FilesystemLoader('templates'),
    ManagerInterface::class => new SessionManager(),
];