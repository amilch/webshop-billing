<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Entities\Order\OrderFactory;
use Domain\Entities\Order\OrderRepository;
use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Enums\OrderStatus;
use Domain\Events\EventService;
use Domain\Events\OrderCreated\OrderCreatedEvent;
use Domain\Events\OrderCreated\OrderCreatedEventFactory;
use Domain\Exceptions\ProductsNotAvailableException;
use Domain\Interfaces\ViewModel;
use Domain\Services\OrderService;
use Domain\Services\ReserveItemsService;
use Domain\ValueObjects\MoneyValueObject;

class CreateOrderInteractor implements CreateOrderInputPort
{
    public function __construct(
        private CreateOrderOutputPort        $output,
        private OrderRepository              $repository,
        private OrderFactory                 $factory,
        private OrderItemFactory             $item_factory,
        private OrderService                 $order_service,
        private EventService                 $eventService,
        private OrderCreatedEventFactory     $eventFactory,
        private ReserveItemsService         $reserveItemsService,
    ) {}

    public function createOrder(CreateOrderRequestModel $request): ViewModel
    {
        $order_items = array_map(fn ($order_item) =>
            $this->item_factory->make([
                'sku' => $order_item['sku'],
                'quantity' => $order_item['quantity'],
            ])
        ,$request->getItems());

        $total = null;
        try{
            $shipping_cost = MoneyValueObject::fromInt(0);
            $total = $this->order_service->computeTotal($order_items);
        } catch(ProductsNotAvailableException $e) {
            return $this->output->unableToCreateOrder("Products not available anymore");
        }

        if (! $total->isEqualTo(MoneyValueObject::fromString($request->getTotal())))
        {
            return $this->output->unableToCreateOrder("Price changed");
        }

        $reserving_successful = $this->reserveItemsService->reserveItems($order_items);
        if (! $reserving_successful)
        {
            return $this->output->unableToCreateOrder("Could not reserve items");
        }

        $order = $this->factory->make([
            'status' => OrderStatus::CREATED,
            'shipping_cost' => $shipping_cost,
            'total' => $total,
            'shipping_address' => $request->getShippingAddress(),
            'payment_data' => $request->getPaymentData(),
            'mail' => $request->getMail(),
        ]);

        $order = $this->repository->insert($order);

        foreach($order_items as $order_item)
        {
            $order->add($order_item);
        }

        $event = $this->eventFactory->make($order->getId(),array_map(fn ($order_item) => [
                'sku' => $order_item->getSku(),
                'quantity' => $order_item->getQuantity(),
            ] ,$order_items));
        $this->eventService->publish($event);

        return $this->output->orderCreated(
            new CreateOrderResponseModel($order)
        );
    }
}
