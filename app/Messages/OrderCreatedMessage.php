<?php

namespace App\Messages;

use Domain\UseCases\CreateOrder\OrderCreatedMessageModel;

class OrderCreatedMessage implements RabbitMQMessage
{
    public function __construct(
        private OrderCreatedMessageModel $message
    ) {}

    public function getRoutingKey(): string
    {
        return "order_created";
    }

    public function toArray(): array
    {
        return [
            'id' => $this->message->getId(),
            'items' => array_map(fn ($item) => [
                'sku' => $item['sku'],
                'quantity' => $item['quantity'],
            ],$this->message->getItems()),
        ];
    }
}
