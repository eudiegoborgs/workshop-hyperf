<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use PhpAmqpLib\Message\AMQPMessage;

#[Consumer(exchange: 'hyperf', routingKey: 'hyperf', queue: 'hyperf', name: "CreateLinkConsumer", nums: 1)]
class CreateLinkConsumer extends ConsumerMessage
{
    public function __construct(private LinkRepositoryInterface $repository)
    {
    }

    public function consumeMessage($data, AMQPMessage $message): string
    {
        $link = new Link($data);
        $this->repository->create($link);
        return Result::ACK;
    }
}
