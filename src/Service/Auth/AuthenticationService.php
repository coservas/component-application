<?php

declare(strict_types=1);

namespace App\Service\Auth;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;

class AuthenticationService
{
    private AuthenticationAdapter $adapter;
    private ZendAuthenticationService $authService;

    public function __construct(ZendAuthenticationService $authService, AuthenticationAdapter $adapter)
    {
        $this->adapter = $adapter;
        $this->authService = $authService;
    }

    public function authenticate(string $username, string $password): Result
    {
        $this->adapter->setUsername($username);
        $this->adapter->setPassword($password);

        return $this->authService->authenticate($this->adapter);
    }

    public function getUser(): ?string
    {
        return $this->authService->getIdentity();
    }
}
