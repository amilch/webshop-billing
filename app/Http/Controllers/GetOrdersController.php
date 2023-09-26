<?php

namespace App\Http\Controllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use Domain\UseCases\GetOrders\GetOrdersInputPort;
use Bschmitt\Amqp\Facades\Amqp;

class GetOrdersController extends Controller
{
    public function __construct(
        private GetOrdersInputPort $interactor,
    ) {}

    public function __invoke()
    {
        $viewModel = $this->interactor->getOrders();

        if ($viewModel instanceof JsonResourceViewModel) {
            return $viewModel->getResource();
        }
    }

}
