<?php declare(strict_types=1);

namespace App\Action;

use Zend\Diactoros\Response\HtmlResponse;

final class BaseAction
{
    protected function render(string $name, array $context = []): HtmlResponse
    {
        return new HtmlResponse(
            $this->templating->render($name, $context)
        );
    }
}