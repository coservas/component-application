<?php

declare(strict_types=1);

namespace App\Action\Auth;

use App\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RegisterAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
//        $res = $this->authService->authenticate('first_user', 'admin');

        return $this->render('register.html.twig', [
//            'name' => $res->getIdentity(),
        ]);
    }
}
