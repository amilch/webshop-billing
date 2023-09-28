<?php

namespace App\Services;

use App\Events\AMQPEvent;
use Bschmitt\Amqp\Facades\Amqp;
use Domain\Events\Event;
use Domain\Events\EventService;

class AMQPService implements EventService
{
    public function publish(Event $event): void
    {
        if ($event instanceof AMQPEvent) {
            $encodedMessage = json_encode($event->toArray());
            Amqp::publish($event->getRoutingKey(), $encodedMessage);
        }
    }
}
