<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUserByEmail(string $username): ?User
    {
        $user = $this->findOneBy(['email' => $username]);
        if ($user instanceof User) {
            return $user;
        }

        return null;
    }
}
