<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Entities\Order\OrderEntity;

class CreateOrderResponseModel
{
    public function __construct(private OrderEntity $order) {}

    public function getOrder(): OrderEntity
    {
        return $this->order;
    }
}
