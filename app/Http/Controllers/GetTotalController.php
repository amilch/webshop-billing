<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\GetTotalRequest;
use Domain\UseCases\CreateOrder\CreateOrderInputPort;
use Domain\UseCases\CreateOrder\CreateOrderRequestModel;
use Domain\UseCases\GetTotal\GetTotalInputPort;
use Domain\UseCases\GetTotal\GetTotalRequestModel;

class GetTotalController extends Controller
{
    public function __construct(
        private GetTotalInputPort $interactor,
    ) {}

    public function __invoke(GetTotalRequest $request)
    {
        $viewModel = $this->interactor->getTotal(
            new GetTotalRequestModel($request->validated())
        );

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }
}
