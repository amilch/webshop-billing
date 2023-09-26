<?php

namespace Domain\UseCases\UpdateOrder;

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

    public function getStatus(): int
    {
        return $this->attributes['status'];
    }
}
