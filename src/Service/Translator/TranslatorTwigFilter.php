<?php

declare(strict_types=1);

namespace App\Service\Translator;

class TranslatorTwigFilter
{
    public const NAME = 'trans';
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function translate(string $code, ?string $lang = null): string
    {
        return $lang
            ? $this->translator->translate($code, $lang)
            : $this->translator->translate($code)
        ;
    }
}
