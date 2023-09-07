<?php

declare(strict_types=1);

namespace App\Amqp\Consumer;

use App\Model\Link;
use App\Repository\LinkRepositoryInterface;
use Hyperf\Amqp\Result;
use Hyperf\Amqp\Annotation\Consumer;
use Hyperf\Amqp\Message\ConsumerMessage;
use Hyperf\Context\ApplicationContext;
use PhpAmqpLib\Message\AMQPMessage;

#[Consumer(exchange: 'hyperf', routingKey: 'hyperf', queue: 'hyperf', name: "CreateLinkConsumer", nums: 1)]
class CreateLinkConsumer extends ConsumerMessage
{
    public function consumeMessage($data, AMQPMessage $message): string
    {
        $repository = ApplicationContext::getContainer()->get(LinkRepositoryInterface::class);
        $link = new Link($data);
        $repository->create($link);
        return Result::ACK;
    }
}
