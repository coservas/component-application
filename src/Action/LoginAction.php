<?php declare(strict_types=1);

namespace App\Action;

use App\Service\FormAuthAdapter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use Zend\Authentication\AuthenticationService;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Session\ManagerInterface;
use Zend\Session\SessionManager;

class LoginAction implements RequestHandlerInterface
{
    /* @var ManagerInterface */
    private $session;

    /* @var Environment */
    private $templating;

    /**
     * LoginAction constructor.
     * @param Environment      $templating
     * @param ManagerInterface $session
     */
    public function __construct(Environment $templating, ManagerInterface $session)
    {
        $this->templating = $templating;
        $this->session = $session;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $auth = new FormAuthAdapter();
        $auth->setPassword('admin');
        $res = $auth->authenticate();

        var_dump($res);exit();

        $html = $this->templating->render('main.html.twig');

        return new HtmlResponse($html);
//        return new HtmlResponse('Login action!');
    }
}
