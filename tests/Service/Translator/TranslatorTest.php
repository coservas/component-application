<?php

declare(strict_types=1);

namespace App\Tests\Service\Translator;

use App\Service\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
    private Translator $translator;

    protected function setUp(): void
    {
        $this->translator = $this->createTranslatorAndGet();
    }

    public function testTranslateWithDefaultLanguage(): void
    {
        $actual = $this->translator->translate('username');
        $this->assertEquals('Username', $actual);
    }

    public function testTranslateWithCustomLanguage(): void
    {
        $this->translator->setDefaultLanguage('ru');
        $actual = $this->translator->translate('username');
        $this->assertEquals('Логин', $actual);
    }

    public function testSetInvalidDefaultLanguage(): void
    {
        $this->translator->setDefaultLanguage('fi');
        $actual = $this->translator->getDefaultLanguage();
        $this->assertEquals('en', $actual);
    }

    public function testHasLanguage(): void
    {
        $actual = $this->translator->hasLanguage('en');
        $this->assertTrue($actual);

        $actual = $this->translator->hasLanguage('fi');
        $this->assertFalse($actual);
    }

    private function createTranslatorAndGet(): Translator
    {
        $translator = new Translator();

        foreach ($this->getMessages() as $lang => $messages) {
            foreach ($messages as $code => $message) {
                $translator->addMessage($code, $message, $lang);
            }
        }

        return $translator;
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
