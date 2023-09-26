<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\OrderRepository;
use Domain\Interfaces\ViewModel;

class UpdateOrderInteractor implements UpdateOrderInputPort
{
    public function __construct(
        private UpdateOrderOutputPort $output,
        private OrderRepository       $repository,
    ) {}

    public function updateOrder(UpdateOrderRequestModel $request): ViewModel
    {
        $order = $this->repository->all(
            id: $request->getId(),
        )[0];

        $order->setStatus($request->getStatus());

        return $this->output->order(
            new UpdateOrderResponseModel($order)
        );
    }
}
