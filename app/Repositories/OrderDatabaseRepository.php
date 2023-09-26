<?php

namespace App\Repositories;

use App\Models\Order;
use Domain\Interfaces\OrderEntity;
use Domain\Interfaces\OrderRepository;

class OrderDatabaseRepository implements OrderRepository
{
    public function insert(OrderEntity $order): OrderEntity
    {
        return Order::create([
            'status' => $order->getStatus()->value,
            'shipping_cost' => $order->getShippingCost()->toInt(),
            'total' => $order->getTotal()->toInt(),
            'shipping_address' => $order->getShippingAddress(),
            'payment_data' => $order->getPaymentData(),
        ]);
    }

    public function all(?int $id = null): array
    {
        $builder = Order::query();

        if ($id !== null)
        {
            $builder = $builder->where('id', $id);
        }

        return $builder->get()->all();
    }
}
