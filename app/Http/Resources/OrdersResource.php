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
                'status' => $order->getStatus,
                'shipping_cost' => $order->getShippingCost()->toInt(),
                'total' => $order->getTotal()->toInt(),
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
