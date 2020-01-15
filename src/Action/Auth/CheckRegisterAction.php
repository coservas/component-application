<?php

declare(strict_types=1);

namespace App\Action\Auth;

use App\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CheckRegisterAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();
            if (!$body) {
                throw new \Exception('Empty body');
            }

            $params = json_decode($body, true);
            if (
                null === $params ||
                !isset($params['username']) ||
                !isset($params['password']) ||
                !isset($params['confirm_password'])
            ) {
                throw new \Exception('Params "username" or "password" or "confirm_password" not found');
            }

            if ($params['password'] !== $params['confirm_password']) {
                throw new \Exception('Passwords is mismatching');
            }

            // send mail to email

            return $this->jsonResponse([
                'status' => 'success',
                'message' => 'User found',
                'url' => $this->generator->generate('register-completed'),
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
