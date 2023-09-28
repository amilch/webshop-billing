<?php

namespace Domain\UseCases\GetTotal;

use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Interfaces\ViewModel;
use Domain\Services\OrderService;

class GetTotalInteractor implements GetTotalInputPort
{
    public function __construct(
        private GetTotalOutputPort           $output,
        private OrderItemFactory             $item_factory,
        private OrderService                 $order_service,
    ) {}

    public function getTotal(GetTotalRequestModel $request): ViewModel
    {
        $order_items = array_map(fn ($order_item) =>
            $this->item_factory->make([
                'sku' => $order_item['sku'],
                'quantity' => $order_item['quantity'],
            ])
        ,$request->getItems());

        $total = $this->order_service->computeTotal($order_items);

        return $this->output->total(
            new GetTotalResponseModel($total->toString())
        );
    }
}
