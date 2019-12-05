<?php

declare(strict_types=1);

namespace App\Action;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Zend\Diactoros\Response\HtmlResponse;
use App\Service\Auth\AuthenticationService;

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
     * @param array $context
     * @return HtmlResponse
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $name, array $context): HtmlResponse
    {
        return new HtmlResponse(
            $this->templating->render($name, $context)
        );
    }
}
