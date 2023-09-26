<?php

namespace Domain\UseCases\CreateOrder;

use Domain\Interfaces\ViewModel;

interface CreateOrderInputPort
{
    public function createOrder(CreateOrderRequestModel $request): ViewModel;
}
