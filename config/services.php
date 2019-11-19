<?php

use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

return [
    LoaderInterface::class => new FilesystemLoader('templates'),
];