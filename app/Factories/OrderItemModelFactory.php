<?php

namespace App\Factories;

use App\Models\OrderItem;
use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Entities\OrderItem\OrderItemFactory;

class OrderItemModelFactory implements OrderItemFactory
{
    public function make(array $attributes = []): OrderItemEntity
    {
        $order_item = new OrderItem($attributes);

        return $order_item;
    }
}
