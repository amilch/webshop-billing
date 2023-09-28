<?php

namespace Domain\Events\OrderCreated;

use Domain\Events\Event;

interface OrderCreatedEventFactory
{
    public function make(int $id, array $items): Event;

}
