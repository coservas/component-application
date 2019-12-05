<?php

declare(strict_types=1);

namespace App\Action;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use App\Service\Auth\AuthenticationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginAction extends BaseAction implements RequestHandlerInterface
{
    private EntityManagerInterface $em;

    public function __construct(Environment $templating, AuthenticationService $authService, EntityManagerInterface $em)
    {
        parent::__construct($templating, $authService);
        $this->em = $em;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $conf = $this->em->getRepository(User::class);
        var_dump($conf);
        exit();

        $res = $this->authService->authenticate('first_user', 'admin');

        return $this->render('main.html.twig', [
            'name' => $res->getIdentity(),
        ]);
    }
}
