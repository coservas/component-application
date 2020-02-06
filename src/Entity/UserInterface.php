<?php

declare(strict_types=1);

namespace App\Entity;

interface UserInterface
{
    public function getEmail(): string;
    public function getPassword(): string;
}
