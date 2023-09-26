<?php

namespace Domain\Interfaces;


interface OrderItemFactory
{
    public function make(array $attributes = []): OrderItemEntity;
}
