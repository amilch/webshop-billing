<?php

namespace Domain\Services;

interface QueryPriceService
{
    public function pricesForProducts(array $skus): array;

}
