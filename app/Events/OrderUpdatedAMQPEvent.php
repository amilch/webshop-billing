<?php

namespace App\Events;

use Domain\Events\Event;
use Domain\Events\OrderUpdated\OrderUpdatedEvent;

class OrderUpdatedAMQPEvent implements AMQPEvent
{
    public function __construct(
        private OrderUpdatedEvent $event
    ) {}

    public function getRoutingKey(): string
    {
        return "order_updated";
    }

    public function toArray(): array
    {
        return $this->event->toArray();
    }

    public static function fromArray(array $data): self
    {
        return new self(OrderUpdatedEvent::fromArray($data));
    }
}
