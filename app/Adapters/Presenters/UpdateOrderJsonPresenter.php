<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\OrderUpdatedResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\GetOrders\GetOrdersOutputPort;
use Domain\UseCases\GetOrders\GetOrdersResponseModel;
use Domain\UseCases\UpdateOrder\UpdateOrderOutputPort;
use Domain\UseCases\UpdateOrder\UpdateOrderResponseModel;

class UpdateOrderJsonPresenter implements UpdateOrderOutputPort
{
    public function order(UpdateOrderResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new OrderUpdatedResource($model->getOrder())
        );
    }
}
