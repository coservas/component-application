<?php

declare(strict_types=1);

namespace App\Action\Profile;

use App\Action\BaseAction;
use App\Entity\User;
use App\Service\Auth\AuthenticationService;
use App\Service\Translator\TranslatorInterface;
use Aura\Router\Generator;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

class ProfileAction extends BaseAction implements RequestHandlerInterface
{
    private EntityManagerInterface $em;

    public function __construct(
        Environment $templating,
        AuthenticationService $authService,
        TranslatorInterface $translator,
        Generator $generator,
        EntityManagerInterface $em
    ) {
        parent::__construct($templating, $authService, $translator, $generator);
        $this->em = $em;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = $this->em
            ->getRepository(User::class)
            ->findOneBy(['email' => (string) $this->getUser()]);

        return $this->render('profile.html.twig', [
            'user' => $user,
        ]);
    }
}
