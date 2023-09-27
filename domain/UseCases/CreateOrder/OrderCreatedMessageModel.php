<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Interfaces\Message;

class OrderCreatedMessageModel implements Message
{
    public function __construct(
        private array $attributes
    ) {}

    public function getItems(): array
    {
        return $this->attributes['items'];
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }
}
