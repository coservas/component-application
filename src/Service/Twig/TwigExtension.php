<?php

declare(strict_types=1);

namespace App\Service\Twig;

use App\Service\Translator\TranslatorInterface;
use App\Service\Translator\TranslatorTwigFilter;
use Aura\Router\Generator;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;

final class TwigExtension
{
    private Environment $twig;
    private ContainerInterface $container;

    public function __invoke(): Environment
    {
        return $this->createEnvironment();
    }

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    private function createEnvironment(): Environment
    {
        $this->twig = new Environment($this->container->get(LoaderInterface::class));
        $this->twig->addRuntimeLoader($this->container->get(ContainerLoader::class));

        $this->addGlobals();
        $this->addFilters();
        $this->addFunctions();

        return $this->twig;
    }

    private function addFilters(): void
    {
        $this->twig->addFilter(
            new \Twig\TwigFilter(
                TranslatorTwigFilter::NAME,
                [TranslatorTwigFilter::class, 'translate'],
            )
        );
    }

    private function addFunctions(): void
    {
        $this->twig->addFunction(
            new \Twig\TwigFunction(
                'path',
                [Generator::class, 'generate'],
            )
        );
    }

    private function addGlobals(): void
    {
        $this->twig->addGlobal(
            'lang',
            $this->container->get(TranslatorInterface::class)->getDefaultLanguage(),
        );
    }
}
