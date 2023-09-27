<?php

namespace App\Messages;

use Domain\UseCases\UpdateOrder\OrderUpdatedMessageModel;

class OrderUpdatedMessage implements RabbitMQMessage
{
    public function __construct(
        private OrderUpdatedMessageModel $message
    ) {}

    public function getRoutingKey(): string
    {
        return "order_updated";
    }

    public function toArray(): array
    {
        return [
            'id' => $this->message->getId(),
            'status' => $this->message->getStatus()->value,
        ];
    }
}
