<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\OrderCreatedResource;
use App\Http\Resources\UnableToCreateOrderResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\CreateOrder\CreateOrderOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderResponseModel;

class CreateOrderJsonPresenter implements CreateOrderOutputPort
{
    public function orderCreated(CreateOrderResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new OrderCreatedResource($model->getOrder())
        );
    }

    public function unableToCreateOrder(string $message): ViewModel
    {
        return new JsonResourceViewModel(
            new UnableToCreateOrderResource($message)
        );
    }
}
