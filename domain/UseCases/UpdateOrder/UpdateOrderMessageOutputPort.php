<?php

namespace Domain\UseCases\UpdateOrder;


interface UpdateOrderMessageOutputPort
{
    public function orderUpdated(OrderUpdatedMessageModel $model): void;
}
