<?php

declare(strict_types=1);

namespace App\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class LinkController
{
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        return $response->json($request->all())->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
