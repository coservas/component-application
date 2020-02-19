<?php

declare(strict_types=1);

namespace App\Service\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class AuthenticationAdapter implements AdapterInterface
{
    private string $username;
    private string $password;
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function authenticate(): Result
    {
        $user = $this->getUserRepository()->getUserByEmail($this->username);

        if ($user && password_verify($this->password, $user->getPassword())) {
            return new Result(Result::SUCCESS, $this->username);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository|UserRepository
     */
    public function getUserRepository()
    {
        return $this->em->getRepository(User::class);
    }
}
