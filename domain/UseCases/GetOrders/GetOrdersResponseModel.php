<?php

namespace Domain\UseCases\GetOrders;

class GetOrdersResponseModel
{
    public function __construct(private array $orders) {}

    public function getOrders(): array
    {
        return $this->orders;
    }
}
