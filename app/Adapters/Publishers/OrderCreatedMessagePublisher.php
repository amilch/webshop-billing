<?php

namespace App\Adapters\Publishers;

use App\Messages\OrderCreatedMessage;
use App\Services\RabbitMQService;
use Domain\Interfaces\Message;
use Domain\UseCases\CreateOrder\CreateOrderMessageOutputPort;
use Domain\UseCases\CreateOrder\OrderCreatedMessageModel;

class OrderCreatedMessagePublisher implements CreateOrderMessageOutputPort
{
    public function __construct(
        private readonly RabbitMQService $rabbitMQService
    ) {}
    public function orderCreated(OrderCreatedMessageModel $model): void
    {
        $this->rabbitMQService->publish(
            new OrderCreatedMessage($model));
    }
}
