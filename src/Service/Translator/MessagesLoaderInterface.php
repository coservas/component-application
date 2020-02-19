<?php

declare(strict_types=1);

namespace App\Service\Translator;

interface MessagesLoaderInterface
{
    /**
     * Return ['lang' => [ 'code' => 'message', 'code1' => 'message1' ]]
     *
     * @return array<string, array>
     */
    public function load(): array;
}
