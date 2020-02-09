<?php

namespace App\Service\Translator;

interface TranslatorInterface
{
    public function translate(string $code, string $lang): string;
    public function addMessage(string $code, string $message, string $lang): TranslatorInterface;
}
