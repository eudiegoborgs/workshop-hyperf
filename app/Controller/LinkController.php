<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Link;
use App\Request\LinkRequest;
use App\Resource\LinkResource;
use App\Service\LinkService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HyperfResponse;

class LinkController
{
    public function __construct(private LinkService $service)
    {
    }

    public function create(LinkRequest $request): ResponseInterface
    {
        $request->validated();
        $link = $this->service->create(new Link($request->all()));
        return (new LinkResource($link))->toResponse()->withStatus(StatusCodeInterface::STATUS_CREATED);
    }

    public function getUrlByAlias(HyperfResponse $response, string $alias): ResponseInterface
    {
        return $response->json([
            'url' => $this->service->getUrlByAlias($alias)
        ])->withStatus(StatusCodeInterface::STATUS_OK);
    }
}
