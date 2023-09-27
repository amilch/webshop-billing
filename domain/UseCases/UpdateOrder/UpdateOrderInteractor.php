<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\OrderRepository;
use Domain\Interfaces\ViewModel;

class UpdateOrderInteractor implements UpdateOrderInputPort
{
    public function __construct(
        private UpdateOrderOutputPort               $output,
        private UpdateOrderMessageOutputPort $messageOutput,
        private OrderRepository                 $repository,
    ) {}

    public function updateOrder(UpdateOrderRequestModel $request): ViewModel
    {
        $order = $this->repository->all(
            id: $request->getId(),
        )[0];

        $order->setStatus($request->getStatus());

        $message = new OrderUpdatedMessageModel([
            'id' => $order->getId(),
            'status' => $order->getStatus(),
        ]);
        $this->messageOutput->orderUpdated($message);

        return $this->output->order(
            new UpdateOrderResponseModel($order)
        );
    }
}
