<?php

namespace App\Factories;

use App\Models\Order;
use Domain\Entities\Order\OrderEntity;
use Domain\Entities\Order\OrderFactory;

class OrderModelFactory implements OrderFactory
{
    public function make(array $attributes = []): OrderEntity
    {
        $order = new Order([
            'status' => $attributes['status']->value,
            'shipping_cost' => $attributes['shipping_cost']->toInt(),
            'total' => $attributes['total']->toInt(),
            'shipping_address' => $attributes['shipping_address'],
            'payment_data' => $attributes['payment_data'],
            'mail' => $attributes['mail'],
        ]);

        return $order;
    }
}
