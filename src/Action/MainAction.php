<?php

declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MainAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('main.html.twig', [
            'name' => (string) $this->getUser(),
        ]);
    }
}
