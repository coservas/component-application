<?php

declare(strict_types=1);

namespace App\Service\Translator;

use App\Service\LanguageDetector;

class TranslatorFactory
{
    private LanguageDetector $detector;
    private MessagesLoaderInterface $loader;
    private Translator $translator;

    public function __invoke(): TranslatorInterface
    {
        return $this->createTranslator();
    }

    public function __construct(MessagesLoaderInterface $loader, LanguageDetector $detector)
    {
        $this->loader = $loader;
        $this->detector = $detector;
    }
    
    private function createTranslator(): TranslatorInterface
    {
        $this->translator = new Translator();

        $data = $this->loader->load();
        foreach ($data as $lang => $messages) {
            foreach ($messages as $code => $message) {
                $this->translator->addMessage($code, $message, $lang);
            }
        }

        $this->translator->setDefaultLanguage(
            $this->getDefaultLanguage()
        );

        return $this->translator;
    }

    private function getDefaultLanguage(): string
    {
        $langFromUri = $this->detector->getLanguageFromUri();
        $langFromCookie = $this->detector->getLanguageFromCookie();

        if ($this->translator->hasLanguage($langFromUri)) {
            if ($langFromUri !== $langFromCookie) {
                $this->detector->resetLanguageCookie($langFromUri);
            }

            return $langFromUri;
        }

        $lang = $this->translator->hasLanguage($langFromCookie)
            ? $langFromCookie
            : $this->detector->getLanguageFromHttpAccept();

        $lang = $this->translator->hasLanguage($lang)
            ? $lang
            : $this->translator->getDefaultLanguage();

        if ($lang !== $langFromCookie) {
            $this->detector->resetLanguageCookie($lang);
        }

        return $lang;
    }
}
