<?php declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Env
{
    private const PATH = '.';

    public static function load(): void
    {
        $dotenv = Dotenv::createImmutable(self::PATH);
        $dotenv->load();

        if (file_exists('.env.local')) {
            $dotenv = Dotenv::createMutable(self::PATH, '.env.local');
            $dotenv->load();
        }
    }
}
