<?php

declare(strict_types=1);

namespace App\Service\Translator;

class Translator implements TranslatorInterface
{
    private const DEFAULT = null;
    private const RU = 'ru';
    private const EN = 'en';

    /** @var array<string, array> */
    private array $messages = [];
    private string $defaultLanguage = self::EN;

    public function translate(string $code, ?string $lang = self::DEFAULT): string
    {
        if (!$lang) {
            $lang = $this->defaultLanguage;
        }

        return $this->messages[$code][$lang] ?? '';
    }

    public function addMessage(string $code, string $message, string $lang): Translator
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

    public function setDefaultLanguage(string $lang): void
    {
        if ($this->hasLanguage($lang)) {
            $this->defaultLanguage = $lang;
        }
    }

    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }
}
