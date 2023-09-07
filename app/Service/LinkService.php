<?php

declare(strict_types=1);

namespace App\Service;

use App\Amqp\Producer\CreateLinkProducer;
use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use Hyperf\Amqp\Producer;
use Hyperf\Coroutine\Parallel;
use Hyperf\HttpMessage\Exception\NotFoundHttpException;
use Hyperf\Redis\Redis;

class LinkService
{
    public function __construct(
        private LinkRepositoryInterface $repository,
        private Redis $cache,
        private Producer $producer
    ) {
    }

    public function create(Link $link): Link
    {
        if (! $link->alias) {
            $link->alias = dechex(time() + rand());
        }
        $parallel = new Parallel();
        $parallel->add(fn() => $this->cache->set($link->alias, $link->url), 'cache');
        $parallel->add(fn() => $this->producer->produce(new CreateLinkProducer($link)), 'queue');
        $parallel->wait();
        return $link;
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