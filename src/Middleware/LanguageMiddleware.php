<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LanguageMiddleware implements MiddlewareInterface
{
    private const DEFAULT_LANGUAGE = 'en';
    private const LANGUAGES = ['ru', 'en'];
    private const COOKIE_KEY = 'LOCALE';

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $lang = $request->getCookieParams()[self::COOKIE_KEY] ?? '';
        if (!$lang) {
            $lang = $this->getLanguageFromHttpAccept($request);
            $this->setCookie($lang);
        }

        $request->withHeader('X-Language', $this->checkLanguageAndGet($lang));
        return $handler->handle($request);
    }

    private function getLanguageFromHttpAccept(ServerRequestInterface $request): string
    {
        $acceptLanguage = substr(
            $request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? '', 0, 2
        );

        return $this->checkLanguageAndGet($acceptLanguage);
    }

    private function checkLanguageAndGet(string $lang): string
    {
        return in_array($lang, self::LANGUAGES, true)
            ? $lang
            : self::DEFAULT_LANGUAGE;
    }

    private function setCookie(string $lang): void
    {
        setcookie(self::COOKIE_KEY, $lang, [
            'expires' => strtotime('+1 year'),
            'path' => '/',
            'httponly' => true,
//            'secure' => true,
        ]);
    }
}
