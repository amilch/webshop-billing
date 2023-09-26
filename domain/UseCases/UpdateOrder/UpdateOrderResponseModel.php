<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\OrderEntity;

class UpdateOrderResponseModel
{
    public function __construct(private OrderEntity $order) {}

    public function getOrder(): OrderEntity
    {
        return $this->order;
    }
}
