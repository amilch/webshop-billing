<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Entities\Order\OrderEntity;

class UpdateOrderResponseModel
{
    public function __construct(private OrderEntity $order) {}

    public function getOrder(): OrderEntity
    {
        return $this->order;
    }
}
