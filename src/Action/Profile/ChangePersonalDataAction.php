<?php

declare(strict_types=1);

namespace App\Action\Profile;

use App\Action\BaseAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ChangePersonalDataAction extends BaseAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getBody()->getContents();
            if (!$body) {
                throw new \Exception('Empty body');
            }

            $params = json_decode($body, true);

            return $this->jsonResponse([
                'status' => 'success',
                'message' => 'Updated success',
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
