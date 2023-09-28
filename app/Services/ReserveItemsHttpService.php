<?php

namespace App\Services;

use Domain\Services\QueryPriceService;
use Domain\Services\ReserveItemsService;
use Domain\ValueObjects\MoneyValueObject;
use Illuminate\Support\Facades\Http;

class ReserveItemsHttpService implements ReserveItemsService
{

    public function reserveItems(array $items): bool
    {
        if (sizeof($items) == 0)
        {
            return false;
        }

        $response = Http::withoutVerifying()
            ->withBody(json_encode([
                'items' => array_map(fn ($item) => [
                    'sku' => $item->getSku(),
                    'quantity' => $item->getQuantity(),
                ], $items)
            ]))
            ->withHeaders([
                'Accept' => 'application/json'
            ])
            ->post('warehouse:8000/reserve');

        return 200 == $response->status();
    }
}
