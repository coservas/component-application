<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\Auth\AuthenticationService;
use App\Service\Translator\TranslatorInterface;
use Aura\Router\Generator;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

abstract class BaseAction
{
    private TranslatorInterface $translator;
    protected Environment $templating;
    protected AuthenticationService $authService;
    protected Generator $generator;

    public function __construct(
        Environment $templating,
        AuthenticationService $authService,
        TranslatorInterface $translator,
        Generator $generator
    ) {
        $this->templating = $templating;
        $this->authService = $authService;
        $this->translator = $translator;
        $this->generator = $generator;
    }

    /**
     * @param string $name
     * @param array<string, string|array> $context
     * @return HtmlResponse
     * @throws LoaderError
     * @throws SyntaxError
     * @throws RuntimeError
     */
    protected function render(string $name, array $context): HtmlResponse
    {
        return new HtmlResponse(
            $this->templating->render($name, $context)
        );
    }

    /**
     * @param array<mixed> $data
     * @param int $status
     * @return JsonResponse
     */
    protected function jsonResponse(array $data, int $status = 200): JsonResponse
    {
        return new JsonResponse($data, $status);
    }

    protected function getUser(): ?string
    {
        return $this->authService->getUser();
    }

    protected function trans(string $code, string $lang = TranslatorInterface::EN_LANG): string
    {
        return $this->translator->translate($code, $lang);
    }
}
