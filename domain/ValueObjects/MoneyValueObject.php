<?php

namespace Domain\ValueObjects;

use InvalidArgumentException;

class MoneyValueObject
{
    private function __construct(private int $value) {}

    public static function fromString(string $value): self
    {
        $split = explode(',', $value);
        if (sizeOf($split) == 1)
        {
            return new self($split[0] * 100);
        } else if (sizeOf($split) == 2) {
           if (strlen($split[1]) == 1) {
               return new self($split[0] * 100 + $split[1] * 10);
           } else if (strlen($split[1]) == 2) {
               return new self($split[0] * 100 + $split[1]);
           }
        }
        throw new InvalidArgumentException('Invalid money string: ' .  $value);
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
