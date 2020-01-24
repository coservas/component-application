<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Entity\UserInterface;
use App\Service\Auth\AuthenticationService;
use Aura\Router\RouterContainer;
use Zend\Diactoros\Response\RedirectResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    private RouterContainer $router;
    private AuthenticationService $auth;
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, AuthenticationService $auth, RouterContainer $router)
    {
        $this->auth = $auth;
        $this->router = $router;
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->getUser();

        $accessControlList = $this->container->get('config')['security']['access_control'];
        foreach ($accessControlList as $item) {
            if (!preg_match(sprintf("#%s#", $item['path']), $request->getUri()->getPath()) && !$user) {
                continue;
            }

            return new RedirectResponse(
                (string) $this->router->getGenerator()->generate('login')
            );
        }

        return $handler->handle($request->withAttribute(UserInterface::class, $user));
    }
}
