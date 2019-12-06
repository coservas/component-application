<?php

declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginAction extends BaseAction implements RequestHandlerInterface
{
//    public function __construct(Environment $templating, AuthenticationService $authService, EntityManagerInterface $em)
//    {
//        parent::__construct($templating, $authService);
//        $this->em = $em;
//    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $res = $this->authService->authenticate('first_user', 'admin');

        return $this->render('main.html.twig', [
            'name' => $res->getIdentity(),
        ]);
    }
}
