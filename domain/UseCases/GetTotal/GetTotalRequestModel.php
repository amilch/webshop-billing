<?php

namespace Domain\UseCases\GetTotal;

class GetTotalRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(
        private array $attributes
    ) {}

    public function getItems(): array
    {
        return $this->attributes['items'];
    }
}
