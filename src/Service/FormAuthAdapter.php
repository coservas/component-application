<?php

namespace App\Service;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class FormAuthAdapter implements AdapterInterface
{
    private string $username;
    private string $password;

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
        $hash = password_hash('admin', PASSWORD_BCRYPT);

        if (password_verify($this->password, $hash)) {
            return new Result(Result::SUCCESS, $hash);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }
}