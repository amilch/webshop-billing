<?php

namespace Domain\Entities\OrderItem;


interface OrderItemFactory
{
    public function make(array $attributes = []): OrderItemEntity;
}
