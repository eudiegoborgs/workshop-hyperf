<?php

declare(strict_types=1);

namespace App\Amqp\Producer;

use App\Model\Link;
use Hyperf\Amqp\Annotation\Producer;
use Hyperf\Amqp\Message\ProducerMessage;

#[Producer(exchange: 'hyperf', routingKey: 'hyperf')]
class CreateLinkProducer extends ProducerMessage
{
    public function __construct(Link $link)
    {
        $this->payload = $link;
    }
}
