<?php

namespace App\Service\Translator;

interface TranslatorInterface
{
    public const RU_LANG = 'ru';
    public const EN_LANG = 'en';

    public function translate(string $code, string $lang = self::EN_LANG): string;
    public function addMessage(string $code, string $message, string $lang = self::EN_LANG): TranslatorInterface;
}
