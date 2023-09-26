<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Enums\OrderStatus;
use Domain\Interfaces\OrderFactory;
use Domain\Interfaces\OrderItemFactory;
use Domain\Interfaces\OrderRepository;
use Domain\Interfaces\ViewModel;
use Domain\ValueObjects\MoneyValueObject;

class CreateOrderInteractor implements CreateOrderInputPort
{
    public function __construct(
        private CreateOrderOutputPort        $output,
        private CreateOrderMessageOutputPort $messageOutput,
        private OrderRepository              $repository,
        private OrderFactory                 $factory,
        private OrderItemFactory             $item_factory,
    ) {}

    public function createOrder(CreateOrderRequestModel $request): ViewModel
    {
        $order_items = array_map(fn ($order_item) =>
            $this->item_factory->make([
                'sku' => $order_item['sku'],
                'quantity' => $order_item['quantity'],
            ])
        ,$request->getItems());

        $shipping_cost = MoneyValueObject::fromInt(0);
        $total = MoneyValueObject::fromInt(3000);

        if (! $total->isEqualTo(MoneyValueObject::fromInt($request->getTotal())))
        {
            return $this->output->unableToCreateOrder("Price changed");
        }


        $order = $this->factory->make([
            'status' => OrderStatus::CREATED,
            'shipping_cost' => $shipping_cost,
            'total' => $total,
            'shipping_address' => $request->getShippingAddress(),
            'payment_data' => $request->getPaymentData(),
        ]);

        $order = $this->repository->insert($order);

        foreach($order_items as $order_item)
        {
            $order->add($order_item);
        }

        $message = new OrderCreatedMessageModel([
            'items' => array_map(fn ($order_item) => [
                'sku' => $order_item->getSku(),
                'quantity' => $order_item->getQuantity(),
            ] ,$order_items)
        ]);
        $this->messageOutput->orderCreated($message);

        return $this->output->orderCreated(
            new CreateOrderResponseModel($order)
        );
    }
}
