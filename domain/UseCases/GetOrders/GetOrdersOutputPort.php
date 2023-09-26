<?php

namespace Domain\UseCases\GetOrders;

use Domain\Interfaces\ViewModel;

interface GetOrdersOutputPort
{
    public function orders(GetOrdersResponseModel $model): ViewModel;
}
