<?php

namespace Domain\UseCases\GetTotal;

class GetTotalResponseModel
{
    public function __construct(private string $total) {}

    public function getTotal(): string
    {
        return $this->total;
    }
}
