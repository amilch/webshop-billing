<?php

namespace Domain\UseCases\GetTotal;

use Domain\Interfaces\OrderEntity;

class GetTotalResponseModel
{
    public function __construct(private int $total) {}

    public function getTotal(): int
    {
        return $this->total;
    }
}
