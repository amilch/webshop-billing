<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Entities\Order\OrderRepository;
use Domain\Events\EventService;
use Domain\Events\OrderUpdated\OrderUpdatedEvent;
use Domain\Events\OrderUpdated\OrderUpdatedEventFactory;
use Domain\Interfaces\ViewModel;

class UpdateOrderInteractor implements UpdateOrderInputPort
{
    public function __construct(
        private UpdateOrderOutputPort               $output,
        private OrderRepository                 $repository,
        private EventService                    $eventService,
        private OrderUpdatedEventFactory        $eventFactory,
    ) {}

    public function updateOrder(UpdateOrderRequestModel $request): ViewModel
    {
        $order = $this->repository->all(
            id: $request->getId(),
        )[0];

        $order->setStatus($request->getStatus());

        $event = $this->eventFactory->make($order->getId(), $order->getStatus());
        $this->eventService->publish($event);

        return $this->output->order(
            new UpdateOrderResponseModel($order)
        );
    }
}
