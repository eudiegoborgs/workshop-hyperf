<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;

class LinkService
{
    public function __construct(private LinkRepositoryInterface $repository)
    {
    }

    public function create(Link $link): Link
    {
        return $this->repository->create($link);
    }
}