<?php

namespace Domain\Interfaces;

interface QueryPriceService
{
    public function pricesForProducts(array $skus): array;

}
