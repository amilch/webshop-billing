<?php

namespace App\Adapters\ViewModels;

use Domain\Interfaces\ViewModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResourceViewModel implements ViewModel
{

    public function __construct(
        private JsonResource $resource,
        private int $status_code = \Illuminate\Http\Response::HTTP_OK
    ) { }

    public function getResource(): JsonResponse
    {
        return $this->resource->response()->setStatusCode($this->status_code);
    }
}
