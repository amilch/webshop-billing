<?php

namespace Domain\Services;

use Domain\Exceptions\ProductsNotAvailableException;
use Domain\ValueObjects\MoneyValueObject;

class OrderService
{
    public function __construct(
        private QueryPriceService $queryPriceService,
    ) {}
    public function computeTotal(array $order_items)
    {
        $prices = $this->queryPriceService->pricesForProducts(array_map(
            fn ($item) => $item->getSku(), $order_items));
        $prices = array_map(fn ($price) => $price->toInt(), $prices);
        $quantities = array_map(fn ($item) => $item->getQuantity(), $order_items);

        if (sizeof($prices) != sizeof($order_items))
        {
            throw new ProductsNotAvailableException();
        }

        $total_int = 0;
        foreach (array_keys($order_items) as $key)
        {
            $total_int += $prices[$key] * $quantities[$key];
        }

        return MoneyValueObject::fromInt($total_int);
    }
}
