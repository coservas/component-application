<?php

declare(strict_types=1);

namespace App\Entity;

interface UserInterface
{
    public function getEmail();
    public function getPassword();
}
