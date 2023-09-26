<?php

namespace Domain\UseCases\CreateOrder;

class CreateOrderRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}

    public function getItems(): array
    {
        return $this->attributes['items'];
    }

    public function getShippingAddress(): string
    {
        return $this->attributes['shipping_address'];
    }

    public function getPaymentData(): string
    {
        return $this->attributes['payment_data'];
    }

    public function getTotal(): string
    {
        return $this->attributes['total'];
    }
}
