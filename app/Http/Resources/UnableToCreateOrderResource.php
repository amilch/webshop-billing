<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnableToCreateOrderResource extends JsonResource
{
    public function __construct(
        private string $msg
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->msg
        ];
    }
}
