<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\Auth\AuthenticationService;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

abstract class BaseAction
{
    protected Environment $templating;
    protected AuthenticationService $authService;

    public function __construct(Environment $templating, AuthenticationService $authService)
    {
        $this->templating = $templating;
        $this->authService = $authService;
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

    protected function jsonResponse(array $data, int $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    protected function getUser(): ?string
    {
        return $this->authService->getUser();
    }
}
