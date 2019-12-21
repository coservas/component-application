<?php

declare(strict_types=1);

namespace App\Service\Translator;

class Translator implements TranslatorInterface
{
    /** @var array<string, array> */
    protected array $messages = [];

    public function translate(string $code, string $lang = self::RU_LANG): string
    {
        return $this->messages[$code][$lang] ?? '';
    }

    public function addMessage(string $code, string $message, string $lang = self::RU_LANG): Translator
    {
        $this->messages[$code][$lang] = $message;
        return $this;
    }
}