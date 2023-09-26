<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    public function __construct(
        protected array $orders
    ) {}

    public function toArray($request)
    {
        return [
            'data' => array_map(fn ($order) => [
                'id' => $order->id,
                'created' => $order->getCreated()->format('d.m.y H:i'),
                'status' => $order->getStatus()->value,
                'shipping_cost' => $order->getShippingCost()->toInt(),
                'total' => $order->getTotal()->toString(),
                'shipping_address' => $order->getShippingAddress(),
                'payment_data' => $order->getPaymentData(),
                'items' => array_map(fn ($item) => [
                    'sku' => $item['sku'],
                    'quantity' => $item['quantity'],
                ], $order->getItems()),
            ], $this->orders),
        ];
    }
}
