<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class LoginAction implements RequestHandlerInterface
{
    /**
     * @var RequestHandlerInterface
     */
    private $action;

    public function __construct(RequestHandlerInterface $action)
    {
        $this->action = $action;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
//        return $this->action->handle($request);
        return new HtmlResponse('Login action!');
    }
}