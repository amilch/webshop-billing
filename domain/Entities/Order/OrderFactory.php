<?php

namespace Domain\Entities\Order;


interface OrderFactory
{
    public function make(array $attributes = []): OrderEntity;
}
