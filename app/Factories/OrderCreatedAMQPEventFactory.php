<?php

namespace App\Factories;

use App\Events\OrderCreatedAMQPEvent;
use App\Events\OrderUpdatedAMQPEvent;
use App\Models\OrderItem;
use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Enums\OrderStatus;
use Domain\Events\Event;
use Domain\Events\OrderCreated\OrderCreatedEvent;
use Domain\Events\OrderCreated\OrderCreatedEventFactory;
use Domain\Events\OrderUpdated\OrderUpdatedEvent;
use Domain\Events\OrderUpdated\OrderUpdatedEventFactory;

class OrderCreatedAMQPEventFactory implements OrderCreatedEventFactory
{
    public function make(int $id, array $items): Event
    {
        return new OrderCreatedAMQPEvent(
            new OrderCreatedEvent($id, $items)
        );
    }
}
