<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\OrdersResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\GetOrders\GetOrdersOutputPort;
use Domain\UseCases\GetOrders\GetOrdersResponseModel;

class GetOrdersJsonPresenter implements GetOrdersOutputPort
{
    public function orders(GetOrdersResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new OrdersResource($model->getOrders())
        );
    }
}
