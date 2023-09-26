<?php

namespace App\Factories;

use App\Models\OrderItem;
use Domain\Interfaces\OrderItemEntity;
use Domain\Interfaces\OrderItemFactory;

class OrderItemModelFactory implements OrderItemFactory
{
    public function make(array $attributes = []): OrderItemEntity
    {
        $order_item = new OrderItem($attributes);

        return $order_item;
    }
}
