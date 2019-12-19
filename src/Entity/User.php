<?php

declare(strict_types=1);

namespace App\Entity;

class User implements UserInterface
{
    private int $id;
    private string $email;

    /** @var string[] */
    public array $roles = [];

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

//    public function getRoles(): iterable
//    {
//        return $this->roles;
//    }
//
//    public function setRoles(array $roles): void
//    {
//        $this->roles = $roles;
//    }
//
//    public function addRole(string $role): void
//    {
//        $this->roles[] = $role;
//    }
//
//    public function deleteRole(string $role): void
//    {
//        if (isset($this->roles[$role])) {
//            unset($this->roles[$role]);
//        }
//    }
}
