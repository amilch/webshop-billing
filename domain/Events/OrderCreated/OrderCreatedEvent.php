<?php

namespace Domain\Events\OrderCreated;

use Domain\Entities\OrderItem\OrderItemEntity;
use Domain\Entities\OrderItem\OrderItemFactory;
use Domain\Events\Event;

class OrderCreatedEvent implements Event
{
    public function __construct(
        private int $id,
        private array $items,
    ) { }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function fromArray(array $data): self
    {
        $items = array_map(fn ($item) => [
            'sku' => $item['sku'],
            'quantity' => $item['quantity'],
        ], $data['items']);

        return new self($data['id'], $data['items']);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'items' => array_map(fn ($item) => [
                'sku' => $item['sku'],
                'quantity' => $item['quantity'],
            ],$this->items),
        ];
    }
}
