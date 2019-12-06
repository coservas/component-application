<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\Auth\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Twig\Environment;

abstract class BaseAction
{
    protected Environment $templating;
    protected AuthenticationService $authService;

    public function __construct(Environment $templating, AuthenticationService $authService)
    {
        $this->templating = $templating;
        $this->authService = $authService;
    }

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
