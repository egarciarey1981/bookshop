<?php

namespace Bookshop\Catalog\Domain\ValueObject;

abstract class ValueObject
{
    abstract protected function value(): mixed;
    abstract protected function name(): string;

    public function equals(mixed $object): bool
    {
        if (!$object instanceof static) {
            return false;
        }

        return $object->value() === $this->value();
    }
}
