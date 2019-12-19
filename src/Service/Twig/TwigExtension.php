<?php

declare(strict_types=1);

namespace App\Service\Twig;

use App\Service\Translator\TranslatorTwigFilter;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

class TwigExtension
{
    private Environment $twig;
    private ContainerInterface $container;

    public function __invoke(ContainerInterface $container): Environment
    {
        $this->container = $container;
        return $this->createEnvironment();
    }

    protected function createEnvironment(): Environment
    {
        $this->twig = new Environment($this->container->get(LoaderInterface::class));

        $this->addFilters();

        return $this->twig;
    }

    protected function addFilters(): void
    {
        $this->twig->addFilter(new \Twig\TwigFilter(
            TranslatorTwigFilter::NAME,
            [$this->container->get(TranslatorTwigFilter::class), 'translate'],
        ));
    }
}