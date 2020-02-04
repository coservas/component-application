<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Entity\UserInterface;
use App\Service\Auth\AuthenticationService;
use Aura\Router\Generator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;

class AuthenticationMiddleware implements MiddlewareInterface
{
    private AuthenticationService $auth;
    private ContainerInterface $container;
    private Generator $generator;

    public function __construct(ContainerInterface $container, AuthenticationService $auth, Generator $generator)
    {
        $this->auth = $auth;
        $this->container = $container;
        $this->generator = $generator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $this->auth->getUser();
        $list = $this->container->get('config')['security']['access_control'];

        foreach ($list as $item) {
            $path = $request->getUri()->getPath();

            $isSecurityPath = !!(preg_match(sprintf("#%s#", $item['path']), $path));
            if ($isSecurityPath && !$user) {
                return new RedirectResponse(
                    (string) $this->generator->generate('login')
                );
            }
        }

        return $handler->handle($request->withAttribute(UserInterface::class, $user));
    }
}
