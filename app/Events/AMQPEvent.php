<?php

namespace App\Events;

use Domain\Events\Event;

interface AMQPEvent extends Event
{
    public function getRoutingKey(): string;

}
