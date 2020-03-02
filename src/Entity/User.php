<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(length=255, nullable=true)
     */
    private string $password;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private string $fname;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private string $sname;

    /**
     * @ORM\Column(length=255, nullable=true)
     */
    private string $mname;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getFname(): string
    {
        return $this->fname;
    }

    /**
     * @param string $fname
     *
     * @return User
     */
    public function setFname(string $fname): User
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * @return string
     */
    public function getSname(): string
    {
        return $this->sname;
    }

    /**
     * @param string $sname
     *
     * @return User
     */
    public function setSname(string $sname): User
    {
        $this->sname = $sname;

        return $this;
    }

    /**
     * @return string
     */
    public function getMname(): string
    {
        return $this->mname;
    }

    /**
     * @param string $mname
     *
     * @return User
     */
    public function setMname(string $mname): User
    {
        $this->mname = $mname;

        return $this;
    }
}
