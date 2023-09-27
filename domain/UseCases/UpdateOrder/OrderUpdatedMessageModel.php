<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\Message;
use Domain\Enums\OrderStatus;

class OrderUpdatedMessageModel implements Message
{
    public function __construct(
        private array $attributes
    ) {}

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function getStatus(): OrderStatus
    {
        return $this->attributes['status'];
    }

}
