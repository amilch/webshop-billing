<?php

namespace Domain\Interfaces;

use Domain\Enums\OrderStatus;
use Domain\ValueObjects\MoneyValueObject;

interface OrderEntity
{
    public function getStatus(): OrderStatus;

    public function getShippingCost(): MoneyValueObject;

    public function getTotal(): MoneyValueObject;

    public function getShippingAddress(): string;

    public function getPaymentData(): string;

    public function add(OrderItemEntity $order_item): void;

    public function setStatus(OrderStatus $status): void;

    public function getItems(): array;
}
