<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\ViewModel;
use Domain\UseCases\GetOrders\GetOrdersResponseModel;

interface UpdateOrderOutputPort
{
    public function order(UpdateOrderResponseModel $model): ViewModel;
}
