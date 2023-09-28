<?php

namespace Domain\Entities\Order;

use Carbon\Carbon;
use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Enums\OrderStatus;
use Domain\ValueObjects\MoneyValueObject;

interface OrderEntity
{
    public function getId(): int;

    public function getStatus(): OrderStatus;

    public function getShippingCost(): MoneyValueObject;

    public function getTotal(): MoneyValueObject;

    public function getShippingAddress(): string;

    public function getPaymentData(): string;

    public function add(OrderItemEntity $order_item): void;

    public function setStatus(OrderStatus $status): void;

    public function getItems(): array;

    public function getCreated(): Carbon;

    public function getMail(): string;
}
