<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private int $id;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="array")
     * @var string[]
     */
    private array $roles = [];

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
