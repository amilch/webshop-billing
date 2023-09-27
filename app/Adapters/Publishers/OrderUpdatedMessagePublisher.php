<?php

namespace App\Adapters\Publishers;

use App\Messages\OrderUpdatedMessage;
use App\Services\RabbitMQService;
use Domain\UseCases\UpdateOrder\OrderUpdatedMessageModel;
use Domain\UseCases\UpdateOrder\UpdateOrderMessageOutputPort;

class OrderUpdatedMessagePublisher implements UpdateOrderMessageOutputPort
{
    public function __construct(
        private RabbitMQService $rabbitMQService
    ) {}
    public function orderUpdated(OrderUpdatedMessageModel $model): void
    {
        $this->rabbitMQService->publish(
            new OrderUpdatedMessage($model));
    }
}
