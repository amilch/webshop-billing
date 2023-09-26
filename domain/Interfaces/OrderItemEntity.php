<?php

namespace Domain\Interfaces;

interface OrderItemEntity
{
    public function getSku(): string;

    public function getQuantity(): int;
}
