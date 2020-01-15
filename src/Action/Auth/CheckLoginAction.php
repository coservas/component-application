<?php

declare(strict_types=1);

namespace App\Action\Auth;

use App\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CheckLoginAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();
            if (!$body) {
                throw new \Exception('Empty body');
            }

            $params = json_decode($body, true);
            if (null === $params || !isset($params['username']) || !isset($params['password'])) {
                throw new \Exception('Params \'username\' or \'password\' not found');
            }

            $isAuth = $this->authService
                ->authenticate($params['username'], $params['password'])
                ->isValid();

            if (!$isAuth) {
                throw new \Exception($this->trans('wrong_username_or_password'));
            }

            return $this->jsonResponse([
                'status' => 'success',
                'message' => 'User found'
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
