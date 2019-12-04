<?php declare(strict_types=1);

namespace App;

use App\Action\NotFoundAction;
use Aura\Router\RouterContainer;

use League\Container\Container;
use League\Container\ReflectionContainer;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\MiddlewarePipeInterface;

final class Application implements MiddlewarePipeInterface
{
    private Container $container;
    private MiddlewarePipe $pipeline;
    private RouterContainer $router;

    public function __construct()
    {
        $this->setRouter();
        $this->setContainer();
        $this->setMiddleware();

        $this->addParams();
        $this->addRoutes();
        $this->addConfigs();
        $this->addServices();
        $this->addMiddlewares();
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler = null): ResponseInterface
    {
        return $this->pipeline->process($request, $handler ?? $this->container->get(NotFoundAction::class));
    }

    public function pipe(MiddlewareInterface $middleware): void
    {
        $this->pipeline->pipe($middleware);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->handle($request);
    }

    private function addParams(): void
    {
        $parameters = require 'config/parameters.php';
        $this->container->add('parameters', $parameters);
    }

    private function addMiddlewares(): void
    {
        $middlewares = require 'config/middlewares.php';

        foreach ($middlewares as $middleware) {
            $this->pipe($this->container->get($middleware));
        }
    }

    private function addRoutes(): void
    {
        $routes = require 'config/routes.php';

        $map = $this->router->getMap();
        foreach ($routes as $route) {
            if (false !== array_search('get', $route['methods'])) {
                $map->get($route['name'], $route['path'], $route['handler']);
            }
        }
    }

    private function addConfigs()
    {
        $configs = require 'config/config.php';

        $this->container->add('config', $configs);
    }

    private function addServices()
    {
        $services = require 'config/services.php';

        foreach ($services as $id => $concrete) {
            if (is_string($concrete) || is_object($concrete)) {
                $this->container->add($id, $concrete);
                continue;
            }

            if (is_array($concrete)) {
                if ($concrete['args']) {
                    $this->container->add($id, $concrete['class'])->addArguments($concrete['args']);
                } else {
                    $this->container->add($id, $concrete['class']);
                }
                continue;
            }

            throw new \Exception('Non valid scheme.');
        }
    }

    private function setContainer(): void
    {
        $this->container = new Container();
        $this->container->delegate(
            new ReflectionContainer
        );

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
