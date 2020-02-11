<?php

declare(strict_types=1);

namespace App\Service\Translator;

class Translator implements TranslatorInterface
{
    private const DEFAULT = null;

    /** @var array<string, array> */
    private array $messages = [];
    private string $defaultLanguage = 'en';

    public function translate(string $code, ?string $lang = self::DEFAULT): string
    {
        if (!$lang) {
            $lang = $this->defaultLanguage;
        }

        return $this->messages[$lang][$code] ?? '';
    }

    public function addMessage(string $code, string $message, string $lang): Translator
    {
        $this->messages[$lang][$code] = $message;
        return $this;
    }

    public function hasLanguage(string $lang): bool
    {
        return in_array($lang, $this->getEnabledLanguages(), true);
    }

    public function getEnabledLanguages(): array
    {
        return array_keys($this->messages);
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
