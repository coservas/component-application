<?php

declare(strict_types=1);

namespace App\Service\Translator;

class PhpMessagesLoader implements MessagesLoaderInterface
{
    public const DIR_WITH_LANG_FILES = 'config/translations';

    public function load(): array
    {
        $messages = [];
        foreach ($this->getFileNames() as $name) {
            $matches = [];
            if (!preg_match('/.+\.(?<lang>[a-zA-Z]{2})\.php$/', $name, $matches)) {
                continue;
            }

            if (!isset($matches['lang'])) {
                continue;
            }

            $messages[ (string) $matches['lang'] ] = require sprintf(
                '%s%s%s',
                self::DIR_WITH_LANG_FILES,
                DIRECTORY_SEPARATOR,
                $name
            );
        }

        return $messages;
    }

    /**
     * @throws \Exception
     *
     * @return array<int,string>
     */
    private function getFileNames(): array
    {
        $fileNames = scandir(self::DIR_WITH_LANG_FILES);
        if (false === $fileNames) {
            throw new \Exception('Directory not found');
        }

        return $fileNames;
    }
}
