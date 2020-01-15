<?php

declare(strict_types=1);

namespace App\Service\Twig;

use App\Service\Translator\TranslatorTwigFilter;
use Aura\Router\Generator;
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
        $this->addFunctions();

        return $this->twig;
    }

    protected function addFilters(): void
    {
        $this->twig->addFilter(
            new \Twig\TwigFilter(
                TranslatorTwigFilter::NAME,
                [$this->container->get(TranslatorTwigFilter::class), 'translate'],
            )
        );
    }

    protected function addFunctions(): void
    {
        $this->twig->addFunction(
            new \Twig\TwigFunction(
                'path',
                [$this->container->get(Generator::class), 'generate'],
            )
        );
    }
}
