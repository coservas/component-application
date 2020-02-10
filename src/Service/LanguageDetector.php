<?php

declare(strict_types=1);

namespace App\Service;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\ServerRequestFactory;

class LanguageDetector
{
    private const COOKIE_KEY = 'LOCALE';
    private ServerRequest $request;

    public function __construct()
    {
        $this->request = ServerRequestFactory::fromGlobals();
    }

    public function getLanguageFromCookie(): string
    {
        return $this->request->getCookieParams()[self::COOKIE_KEY] ?? '';
    }

    public function getLanguageFromHttpAccept(): string
    {
        return substr(
            $this->request->getServerParams()['HTTP_ACCEPT_LANGUAGE'] ?? '',
            0,
            2
        );
    }

    public function setLanguageCookie(string $lang): void
    {
        setcookie(self::COOKIE_KEY, $lang, [
            'expires' => strtotime('+1 year'),
            'path' => '/',
            'httponly' => true,
        ]);
    }

    public function unsetLanguageCookie(): void
    {
        setcookie(self::COOKIE_KEY, '', [
            'expires' => '-1'
        ]);
    }
}
