<?php

namespace Bookshop\Catalog\Domain\ValueObject;

use InvalidArgumentException;

abstract class IntegerValueObject extends ValueObject
{
    protected int $value;

    public function value(): int
    {
        return $this->value;
    }

    public function __construct(int $value)
    {
        $this->assertValueIsValid($value);
        $this->value = $value;
    }

    abstract protected function assertValueIsValid(int $value): void;

    protected function assertValueIsPositive(int $value): void
    {
        if ($value < 0) {
            throw new InvalidArgumentException(
                sprintf('%s must be positive or zero', $this->name())
            );
        }
    }
}
