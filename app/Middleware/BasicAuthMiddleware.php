<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\HttpMessage\Exception\UnauthorizedHttpException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware implements MiddlewareInterface
{
    public function __construct(protected ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getHeader('Authorization') != 'workshop') {
            throw new UnauthorizedHttpException();
        }
        return $handler->handle($request);
    }
}
