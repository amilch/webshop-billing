<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Interfaces\Message;

interface CreateOrderMessageOutputPort
{
    public function orderCreated(OrderCreatedMessageModel $model): void;
}
