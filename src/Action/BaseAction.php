<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\Auth\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;

abstract class BaseAction
{
    protected \Twig\Environment $templating;
    protected AuthenticationService $authService;

    public function __construct(\Twig\Environment $templating, AuthenticationService $authService)
    {
        $this->templating = $templating;
        $this->authService = $authService;
    }

    /**
     * @param string $name
     * @param array<string, string|array> $context
     * @return HtmlResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     */
    protected function render(string $name, array $context): HtmlResponse
    {
        return new HtmlResponse(
            $this->templating->render($name, $context)
        );
    }

    protected function getUser(): ?string
    {
        return $this->authService->getUser();
    }
}
