<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Entity\UserInterface;
use App\Service\Auth\AuthenticationService;
use Aura\Router\Generator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AuthenticationMiddleware implements MiddlewareInterface
{
    protected AuthenticationService $auth;
    private Generator $routeGenerator;

    public function __construct(AuthenticationService $auth, Generator $routeGenerator)
    {
        $this->auth = $auth;
        $this->routeGenerator = $routeGenerator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->getUser();
        if (null === $user) {
            return new RedirectResponse(
                (string) $this->routeGenerator->generate('login')
            );
        }

        return $handler->handle($request->withAttribute(UserInterface::class, $user));
    }
}
