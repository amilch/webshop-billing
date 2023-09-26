<?php

namespace Domain\UseCases\GetOrders;

use Domain\Interfaces\ViewModel;

interface GetOrdersInputPort
{
    public function getOrders(): ViewModel;
}
