<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Interfaces\ViewModel;

interface CreateOrderOutputPort
{
    public function orderCreated(CreateOrderResponseModel $model): ViewModel;
    public function unableToCreateOrder(string $message): ViewModel;
}
