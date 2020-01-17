<?php

declare(strict_types=1);

namespace App\Service\Twig;

use Psr\Container\ContainerInterface;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class ContainerLoader implements RuntimeLoaderInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function load(string $class)
    {
        return $this->container->get($class);
    }
}
