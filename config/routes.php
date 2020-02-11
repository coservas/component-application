<?php

use App\Service\Translator\TranslatorInterface;

/** @var TranslatorInterface $translator */
$translator = $this->container->get(TranslatorInterface::class);
$defaultLanguage = $translator->getDefaultLanguage();
$enabledLanguages = $translator->getEnabledLanguages();

return [
    [
        'methods' => ['get'],
        'name' => 'main',
        'path' => '/',
        'handler' => App\Action\MainAction::class,
    ],
    [
        'path_prefix' => '/{lang}',
        'tokens' => ['lang' => sprintf('(%s)', implode('|', $enabledLanguages))],
        'defaults' => ['lang' => $defaultLanguage],
        'routes' => require 'routes/language-dependent-routes.php',
    ],
    ... require 'routes/main_redirects.php'
];
