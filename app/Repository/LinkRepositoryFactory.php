<?php

declare(strict_types=1);

namespace App\Repository;

class LinkRepositoryFactory
{
    public function __invoke(): LinkRepositoryInterface
    {
        return new LinkRepository();
    }
}
