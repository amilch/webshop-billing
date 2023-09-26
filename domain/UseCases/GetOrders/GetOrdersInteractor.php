<?php

namespace Domain\UseCases\GetOrders;

use Domain\Interfaces\CategoryRepository;
use Domain\Interfaces\OrderRepository;
use Domain\Interfaces\ViewModel;

class GetOrdersInteractor implements GetOrdersInputPort
{
    public function __construct(
        private GetOrdersOutputPort $output,
        private OrderRepository  $repository,
    ) {}

    public function getOrders(): ViewModel
    {
        $orders = $this->repository->all();

        return $this->output->orders(
            new GetOrdersResponseModel($orders)
        );
    }
}
