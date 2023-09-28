<?php

namespace Domain\Entities\Order;


interface OrderRepository
{
    public function insert(OrderEntity $order): OrderEntity;

    public function all(?int $id): array;
}
