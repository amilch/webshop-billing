<?php

namespace App\Http\Resources;

use Domain\Interfaces\OrderEntity;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderUpdatedResource extends JsonResource
{
    public function __construct(
        protected OrderEntity $order
    ) {}

    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->order->id,
                'status' => $this->order->getStatus()->value,
                'shipping_cost' => $this->order->getShippingCost()->toInt(),
                'total' => $this->order->getTotal()->toString(),
                'shipping_address' => $this->order->getShippingAddress(),
                'payment_data' => $this->order->getPaymentData(),
                'items' => array_map(fn ($item) => [
                    'sku' => $item['sku'],
                    'quantity' => $item['quantity'],
                ], $this->order->getItems()),
            ],
        ];
    }
}
