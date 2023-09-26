<?php

namespace Domain\UseCases\UpdateOrder;

class UpdateOrderResponseModel
{
    public function __construct(private array $order) {}

    public function getOrder(): array
    {
        return $this->order;
    }
}
