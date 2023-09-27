<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TotalResource extends JsonResource
{
    public function __construct(
        protected string $total
    ) {}

    public function toArray($request)
    {
        return [
            'data' => [
                'total' => $this->total,
            ],
        ];
    }
}
