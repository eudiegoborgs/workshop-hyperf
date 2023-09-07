<?php

declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Logger\LoggerFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class RequestAndResponseLoggerMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerFactory $factory)
    {
        $this->logger = $factory->get('workshop');
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $result = $handler->handle($request);
        $this->logger->info('Request and Response', [
            'request' => [
                'headers' => $request->getHeaders(),
                'body' => $request->getBody(),
                'query_params' => $request->getQueryParams(),
            ],
            'result' => $result->getBody()->getContents(),
        ]);
        return $result;
    }
}
