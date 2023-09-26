<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderUpdatedResource extends JsonResource
{
    public function __construct(
        protected array $products
    ) {}

    public function toArray($request)
    {
        return [
            'data' => array_map(fn ($product) => [
                'id' => $product->id,
                'category_id' => $product->getCategoryId(),
                'name' => $product->getName(),
                'sku' => $product->getSku(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice()?->toString(),
                'weight' => $product->getWeight(),
            ], $this->products),
        ];
    }
}
