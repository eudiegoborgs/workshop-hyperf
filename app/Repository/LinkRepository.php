<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Link;

class LinkRepository implements LinkRepositoryInterface
{

    public function create(Link $link): Link
    {
        $link->save();
        return $link;
    }

    public function list(): array
    {
        // TODO: Implement list() method.
    }

    public function show(int $id): ?Link
    {
        return Link::find($id);
    }

    public function update(int $id, array $data): Link
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }
}