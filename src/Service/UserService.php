<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createUser(string $email, string $password): void
    {
        if (!$hash = password_hash($password, PASSWORD_BCRYPT)) {
            throw new \Exception();
        }

        $user = (new User())
            ->setEmail($email)
            ->setPassword($hash);

        $this->em->persist($user);
        $this->em->flush();
    }
}
