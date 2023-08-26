<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpExceptionHandler extends ExceptionHandler
{

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        return $response
            ->withHeader(
                'content-type', 'application/json'
            )
            ->withStatus(
                $throwable->getCode()
            )
            ->withBody(
                new SwooleStream(
                    json_encode(
                        [
                            'message' => $throwable->getMessage(),
                            'file' => $throwable->getFile(),
                            'line' => $throwable->getLine(),
                        ],
                        JSON_UNESCAPED_UNICODE
                    )
                )
            );
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof HttpException;
    }
}