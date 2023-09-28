<?php

namespace Domain\Events\OrderUpdated;

use Domain\Enums\OrderStatus;
use Domain\Events\Event;

class OrderUpdatedEvent implements Event
{
    public function __construct( private int $id, private OrderStatus $status ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'], OrderStatus::from($data['status']));
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'status' => $this->status->value,
        ];
    }


}
