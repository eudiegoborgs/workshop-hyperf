<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use Hyperf\Coroutine\Parallel;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Redis\Redis;

class LinkService
{
    public function __construct(private LinkRepositoryInterface $repository, private Redis $cache)
    {
    }

    public function create(Link $link): Link
    {
        if (! $link->alias) {
            $link->alias = dechex(time() + rand());
        }
        $parallel = new Parallel();
        $parallel->add(fn() => $this->cache->set($link->alias, $link->url), 'cache');
        $parallel->add(fn() => $this->repository->create($link), 'repo');
        $result = $parallel->wait();
        return $result['repo'];
    }

    public function getUrlByAlias(string $alias): string
    {
        $url = $this->cache->get($alias);
        if (!$url) {
            $link = $this->repository->getByAlias($alias);
            if (! $link) {
                throw new NotFoundHttpException();
            }
            return $link->url;
        }
        return $url;
    }
}