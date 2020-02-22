<?php

declare(strict_types=1);

namespace App\Tests\Service\Translator;

use App\Service\Translator\Translator;
use App\Service\Translator\TranslatorTwigFilter;
use PHPUnit\Framework\TestCase;

class TranslatorTwigFilterTest extends TestCase
{
    private TranslatorTwigFilter $filter;

    protected function setUp(): void
    {
        $this->filter = $this->createFilterAndGet();
    }

    public function testTranslateWithDefaultLanguage(): void
    {
        $actual = $this->filter->translate('username');
        $this->assertEquals('Username', $actual);
    }

    public function testTranslateWithCustomLanguage(): void
    {
        $actual = $this->filter->translate('username', 'ru');
        $this->assertEquals('Логин', $actual);
    }

    private function createFilterAndGet(): TranslatorTwigFilter
    {
        $translator = new Translator();

        foreach ($this->getMessages() as $lang => $messages) {
            foreach ($messages as $code => $message) {
                $translator->addMessage($code, $message, $lang);
            }
        }

        return new TranslatorTwigFilter($translator);
    }

    private function getMessages(): array
    {
        return [
            'en' => [
                'username' => 'Username',
            ],
            'ru' => [
                'username' => 'Логин',
            ],
        ];
    }
}
