<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use App\Request\LinkRequest;
use App\Resource\LinkResource;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface;

class LinkController
{
    public function __construct(private LinkRepositoryInterface $repository)
    {
    }

    public function create(LinkRequest $request): ResponseInterface
    {
        $request->validated();
        $link = new Link($request->all());
        if (! $link->alias) {
            $link->alias = dechex(time() + rand());
        }
        $this->repository->create($link);
        return (new LinkResource($link))->toResponse()->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
