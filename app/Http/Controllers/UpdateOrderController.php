<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\UpdateOrderRequest;
use Domain\UseCases\GetOrders\GetOrdersInputPort;
use Domain\UseCases\UpdateOrder\UpdateOrderInputPort;
use Domain\UseCases\UpdateOrder\UpdateOrderRequestModel;

class UpdateOrderController extends Controller
{
    public function __construct(
        private UpdateOrderInputPort $interactor,
    ) {}

    public function __invoke(UpdateOrderRequest $request)
    {
        $viewModel = $this->interactor->updateOrder(
            new UpdateOrderRequestModel($request->validated()));

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }

}
