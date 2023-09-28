<?php

namespace Domain\Events\OrderUpdated;

use Domain\Enums\OrderStatus;
use Domain\Events\Event;

interface OrderUpdatedEventFactory
{
    public function make(int $id, OrderStatus $status): Event;
}
