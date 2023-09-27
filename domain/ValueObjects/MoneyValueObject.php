<?php

namespace Domain\ValueObjects;

class MoneyValueObject
{
    private function __construct(private int $value) {}

    public static function fromString(string $value): self
    {
        $split = explode(',', $value);
        return new self($split[0] * 100  +  $split[1]);
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this;
    }

    public function __toString()
    {
        return number_format($this->value / 100.0, 2, ',', '.');
    }

    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function add(self $other): self
    {
        return new self($this->value + $other->value);
    }
}
