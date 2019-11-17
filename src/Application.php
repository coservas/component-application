<?php declare(strict_types=1);

namespace App;

use App\Action\LoginAction;
use App\Action\NotFoundAction;
use Aura\Router\RouterContainer;

use League\Container\Container;
use League\Container\ReflectionContainer;

use Middlewares\AuraRouter;
use Middlewares\ResponseTime;
use Middlewares\RequestHandler;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\MiddlewarePipeInterface;

final class Application implements MiddlewarePipeInterface
{
    /* @var Container */
    private $container;

    /* @var MiddlewarePipe */
    private $pipeline;

    /* @var RouterContainer */
    private $router;

    /* Application constructor. */
    public function __construct()
    {
        $this->setRouter();
        $this->setContainer();
        $this->setMiddleware();

        $this->addRoutes();
        $this->addMiddlewares();
    }

    /* @inheritDoc */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        if (null === $handler) {
            $handler = $this->container->get(NotFoundAction::class);
        }

        return $this->pipeline->process($request, $handler);
    }

    /* @inheritDoc */
    public function pipe(MiddlewareInterface $middleware): void
    {
        $this->pipeline->pipe($middleware);
    }

    /* @inheritDoc */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->pipeline->handle($request);
    }

    private function addMiddlewares(): void
    {
        $this->pipe($this->container->get(ResponseTime::class));
        $this->pipe($this->container->get(AuraRouter::class));
        $this->pipe($this->container->get(RequestHandler::class));
    }

    private function addRoutes(): void
    {
        $routes = [
            [
                'methods' => [
                    'get'
                ],
                'name' => 'login',
                'path' => '/login',
                'handler' => LoginAction::class
            ],
        ];

        $map = $this->router->getMap();
        foreach ($routes as $route) {
            if (false !== array_search('get', $route['methods'])) {
                $map->get($route['name'], $route['path'], $route['handler']);
            }
        }
    }

    private function setContainer(): void
    {
        $this->container = new Container();
        $this->container->delegate(
            new ReflectionContainer
        );

        $this->container->add(LoaderInterface::class, new FilesystemLoader('templates'));
        $this->container->add(RouterContainer::class, $this->router);
        $this->container->add(ContainerInterface::class, $this->container);
    }

    private function setRouter(): void
    {
        $this->router = new RouterContainer();
    }

    private function setMiddleware(): void
    {
        $this->pipeline = new MiddlewarePipe();
    }
}