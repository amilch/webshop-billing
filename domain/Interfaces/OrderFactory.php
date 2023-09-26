<?php

namespace Domain\Interfaces;


interface OrderFactory
{
    public function make(array $attributes = []): OrderEntity;
}
