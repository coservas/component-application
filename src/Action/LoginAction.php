<?php declare(strict_types=1);

namespace App\Action;

use App\Service\Auth\AuthenticationService;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\ManagerInterface;

class LoginAction implements RequestHandlerInterface
{
    private ManagerInterface $session;
    private Environment $templating;

    private AuthenticationService $authService;

    public function __construct(Environment $templating, ManagerInterface $session, AuthenticationService $authService)
    {
        $this->templating = $templating;
        $this->session = $session;
        $this->authService = $authService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $res = $this->authService->authenticate('first_user', 'admin');

        $html = $this->templating->render('main.html.twig', [
            'name' => $res->getIdentity(),
        ]);

        return new HtmlResponse($html);
    }
}
