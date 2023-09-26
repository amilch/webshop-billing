<?php

namespace Domain\UseCases\UpdateOrder;

use Domain\Interfaces\ViewModel;

interface UpdateOrderInputPort
{
    public function updateOrder(UpdateOrderRequestModel $request): ViewModel;
}
