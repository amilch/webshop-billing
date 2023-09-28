<?php

namespace App\Factories;

use App\Events\OrderUpdatedAMQPEvent;
use App\Models\OrderItem;
use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Enums\OrderStatus;
use Domain\Events\Event;
use Domain\Events\OrderUpdated\OrderUpdatedEvent;
use Domain\Events\OrderUpdated\OrderUpdatedEventFactory;

class OrderUpdatedAMQPEventFactory implements OrderUpdatedEventFactory
{
    public function make(int $id, OrderStatus $status): Event
    {
        return new OrderUpdatedAMQPEvent(
            new OrderUpdatedEvent($id, $status)
        );
    }
}
