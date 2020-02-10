<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Service\Translator\Translator;
use App\Service\Translator\TranslatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageMiddleware implements MiddlewareInterface
{
    private const COOKIE_KEY = 'LOCALE';
    private Translator $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $langFromCookie = $this->getLanguageFromCookie($request);

        $lang = $this->translator->hasLanguage($langFromCookie)
            ? $langFromCookie
            : $this->getLanguageFromHttpAccept($request);

        $lang = $this->translator->hasLanguage($lang)
            ? $lang
            : $this->translator->getDefaultLanguage();

        if ($lang !== $langFromCookie) {
            $this->unsetCookie();
            $this->setCookie($lang);
        }

        return $handler->handle(
            $request->withHeader('X-Language', $lang)
        );
    }

    private function getLanguageFromCookie(ServerRequestInterface $request): string
    {
        return $request->getCookieParams()[self::COOKIE_KEY] ?? '';
    }

    private function getLanguageFromHttpAccept(ServerRequestInterface $request): string
    {
        return substr(
            $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2
        );
    }

    private function setCookie(string $lang): void
    {
        setcookie(self::COOKIE_KEY, $lang, [
            'expires' => strtotime('+1 year'),
            'path' => '/',
            'httponly' => true,
        ]);
    }

    private function unsetCookie(): void
    {
        setcookie(self::COOKIE_KEY, '', [
            'expires' => '-1'
        ]);
    }
}
