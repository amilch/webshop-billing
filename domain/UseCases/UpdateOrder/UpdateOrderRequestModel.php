<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Enums\OrderStatus;

class UpdateOrderRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}


    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getStatus(): OrderStatus
    {
        return OrderStatus::from($this->attributes['status']);
    }
}
