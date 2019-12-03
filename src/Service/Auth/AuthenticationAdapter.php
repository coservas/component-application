<?php declare(strict_types=1);

namespace App\Service\Auth;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class AuthenticationAdapter implements AdapterInterface
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
        $hash = password_hash('admin', PASSWORD_DEFAULT);

        if (password_verify($this->password, $hash)) {
            return new Result(Result::SUCCESS, $this->username);
        }

        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }
}
