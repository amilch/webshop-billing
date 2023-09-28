<?php

namespace Domain\Entities\OrderItem;

interface OrderItemEntity
{
    public function getSku(): string;

    public function getQuantity(): int;
}
