<?php

declare(strict_types=1);

namespace App\Service\Translator;

class Translator implements TranslatorInterface
{
    public const DEFAULT_LANGUAGE = self::EN;
    private const RU = 'ru';
    private const EN = 'en';

    /** @var array<string, array> */
    private array $messages = [];

    public function translate(string $code, string $lang = self::DEFAULT_LANGUAGE): string
    {
        return $this->messages[$code][$lang] ?? '';
    }

    public function addMessage(string $code, string $message, string $lang = self::DEFAULT_LANGUAGE): Translator
    {
        $this->messages[$code][$lang] = $message;
        return $this;
    }

    public function hasLanguage(string $lang): bool
    {
        return in_array($lang, $this->getEnabledLanguages(), true);
    }

    private function getEnabledLanguages(): array
    {
        return [
            self::RU,
            self::EN,
        ];
    }
}
