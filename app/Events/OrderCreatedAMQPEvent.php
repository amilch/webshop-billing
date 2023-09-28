<?php

namespace App\Events;

use Domain\Events\OrderCreated\OrderCreatedEvent;

class OrderCreatedAMQPEvent implements AMQPEvent
{
    public function __construct(
        private OrderCreatedEvent $event
    ) {}

    public function getRoutingKey(): string
    {
        return "order_created";
    }

    public function toArray(): array
    {
        return $this->event->toArray();
    }

    public static function fromArray(array $data): self
    {
        return new self(OrderCreatedEvent::fromArray($data));
    }
}
