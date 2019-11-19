<?php declare(strict_types=1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;

class LoginAction implements RequestHandlerInterface
{
    /* @var Environment */
    private $templating;

    public function __construct(Environment $templating)
    {
        $this->templating = $templating;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->templating->render('main.html.twig');

        return new HtmlResponse($html);
//        return new HtmlResponse('Login action!');
    }
}
