<?php

namespace App\Services;

use Domain\Interfaces\QueryPriceService;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Support\Facades\Http;

class QueryPriceHttpService implements QueryPriceService
{

    public function pricesForProducts(array $skus): array
    {
        $response = Http::withoutVerifying()
            ->withQueryParameters([
                'sku' => join(',', $skus),
            ])
            ->get('catalog:8000/products');
        $products = $response->json()['data'];
        $prices = array_map(
            fn ($product) => MoneyValueObject::fromString($product['price']),
            $products);
        return $prices;
    }
}
