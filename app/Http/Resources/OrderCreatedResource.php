<?php

namespace App\Http\Resources;

use Domain\Interfaces\OrderEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCreatedResource extends JsonResource
{
    public function __construct(
        protected OrderEntity $order
    ) {}

    public function toArray($request)
    {
        return [
            'data' => [
                'created' => $this->order->getCreated()->toISOString(),
                'status' => $this->order->getStatus(),
                'shipping_cost' => $this->order->getShippingCost()->toInt(),
                'total' => $this->order->getTotal()->toInt(),
                'shipping_address' => $this->order->getShippingAddress(),
                'payment_data' => $this->order->getPaymentData(),
                'mail' => $this->order->getMail(),
                'items' => array_map(fn ($item) => [
                    'sku' => $item['sku'],
                    'quantity' => $item['quantity'],
                ], $this->order->getItems()),
            ],
        ];
    }
}
