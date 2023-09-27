<?php

namespace App\Adapters\Presenters;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Resources\OrderCreatedResource;
use App\Http\Resources\TotalResource;
use App\Http\Resources\UnableToCreateOrderResource;
use Domain\Interfaces\ViewModel;
use Domain\UseCases\CreateOrder\CreateOrderOutputPort;
use Domain\UseCases\CreateOrder\CreateOrderResponseModel;
use Domain\UseCases\GetTotal\GetTotalOutputPort;
use Domain\UseCases\GetTotal\GetTotalResponseModel;

class GetTotalJsonPresenter implements GetTotalOutputPort
{
    public function total(GetTotalResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new TotalResource($model->getTotal())
        );
    }

}
