<?php declare(strict_types=1);

namespace App\Entity;

class User implements
{
    private $id;
    private $email;
    private $username;
    private $roles = [];

    public function __construct()
    {
    }

    /**
     * Get the unique user identity (id, username, email address or ...)
     */
    public function getIdentity(): string
    {
        return $this->id;
    }

    /**
     * Get all user roles
     *
     * @return Iterable
     */
    public function getRoles(): iterable
    {
        return $this->roles;
    }

    /**
     * Get a detail $name if present, $default otherwise
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->username;
    }

    /**
     * Get all the details, if any
     */
    public function getDetails(): array
    {
        // TODO: Implement getDetails() method.
    }
}
