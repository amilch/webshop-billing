<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\CreateOrderRequest;
use Domain\UseCases\CreateOrder\CreateOrderInputPort;
use Domain\UseCases\CreateOrder\CreateOrderRequestModel;

class CreateOrderController extends Controller
{
    public function __construct(
        private CreateOrderInputPort $interactor,
    ) {}

    public function __invoke(CreateOrderRequest $request)
    {
        $viewModel = $this->interactor->createOrder(
            new CreateOrderRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
