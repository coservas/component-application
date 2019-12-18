<?php

declare(strict_types=1);

namespace App\Service\Translator;

class TranslatorFactory
{
    private MessagesLoaderInterface $loader;

    public function __invoke(MessagesLoaderInterface $loader): TranslatorInterface
    {
        $this->loader = $loader;
        return $this->createTranslator();
    }

    protected function createTranslator(): TranslatorInterface
    {
        $translator = new Translator();

        $data = $this->loader->load();
        foreach ($data as $lang => $messages) {
            foreach ($messages as $code => $message) {
                $translator->addMessage($code, $message, $lang);
            }
        }

        return $translator;
    }
}
