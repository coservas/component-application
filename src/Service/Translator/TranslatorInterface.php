<?php

namespace App\Service\Translator;

interface TranslatorInterface
{
    public const RU = 'ru';
    public const EN = 'en';

    public function translate(string $code, string $lang = self::EN): string;
    public function addMessage(string $code, string $message, string $lang = self::EN): TranslatorInterface;
}
