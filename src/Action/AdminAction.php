<?php

declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->render('admin.html.twig', [
            'name' => (string) $this->getUser(),
        ]);
    }
}
