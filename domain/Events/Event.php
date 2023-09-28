<?php

namespace Domain\Events;

interface Event
{
    public static function fromArray(array $data): self;

    public function toArray(): array;
}
