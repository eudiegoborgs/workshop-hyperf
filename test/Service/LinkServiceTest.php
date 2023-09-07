<?php

declare(strict_types=1);

namespace HyperfTest\Service;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use App\Service\LinkService;
use PHPUnit\Framework\TestCase;

class LinkServiceTest extends TestCase
{
    public function testCreate()
    {
        $link = new Link([
            'title' => 'Test',
            'url' => 'http://test.com'
        ]);

        $repo = $this->createMock(LinkRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('create')
            ->with($link)
            ->willReturn($link);

        $service = new LinkService($repo);

        $this->assertEquals($link, $service->create($link));
        $this->assertTrue(is_string($link->alias));
        $this->assertNull($link->expires_in);
    }

    public function testCreateWithAliasAndExpiresIn()
    {
        $alias = 'test';
        $expiresIn = (new \DateTime())->format(\DateTimeInterface::W3C);
        $link = new Link([
            'title' => 'Test',
            'url' => 'http://test.com',
            'alias' => $alias,
            'expires_in' => $expiresIn
        ]);

        $repo = $this->createMock(LinkRepositoryInterface::class);
        $repo->expects($this->once())
            ->method('create')
            ->with($link)
            ->willReturn($link);

        $service = new LinkService($repo);

        $this->assertEquals($link, $service->create($link));
        $this->assertEquals($alias, $link->alias);
        $this->assertEquals($expiresIn, $link->expires_in);
    }
}
