<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Env
{
    private const PATHS = ['.'];

    public static function load(): void
    {
        $dotenv = Dotenv::createImmutable(self::PATHS);
        $dotenv->load();

        if (file_exists('.env.local')) {
            $dotenv = Dotenv::createMutable(self::PATHS, '.env.local');
            $dotenv->load();
        }
    }
}
