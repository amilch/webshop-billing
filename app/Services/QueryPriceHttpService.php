<?php

namespace App\Services;

use Domain\Services\QueryPriceService;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Support\Facades\Http;

class QueryPriceHttpService implements QueryPriceService
{

    public function pricesForProducts(array $skus): array
    {
        if (sizeof($skus) == 0)
        {
            return [];
        }

        $response = Http::withoutVerifying()
            ->withQueryParameters([
                'sku' => join(',', $skus),
            ])
            ->get('catalog:8000/products');
        $products = $response->json()['data'];

        $pricesBySku = [];
        foreach ($products as $product)
        {
            $pricesBySku[$product['sku']] = MoneyValueObject::fromString($product['price']);
        }

        $prices = [];
        foreach ($skus as $sku)
        {
            array_push($prices, $pricesBySku[$sku]);
        }
        return $prices;
    }
}
