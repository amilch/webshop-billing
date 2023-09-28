<?php

namespace Domain\Events;

interface EventService
{
    public function publish(Event $event): void;

}
