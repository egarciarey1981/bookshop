<?php

namespace Bookshop\Catalog\Domain\ValueObject;

use Bookshop\Catalog\Domain\Exception\DomainException;

abstract class StringValueObject extends ValueObject
{
    private const ERROR_IS_EMPTY = '%s cannot be empty';
    private const ERROR_TOO_SHORT = '%s must be at least %d characters long';
    private const ERROR_TOO_LONG = '%s must be at most %d characters long';
    private const ERROR_NOT_UUID = '%s must be a valid UUID';

    protected string $value;

    public function __construct(string $value)
    {
        $this->assertValueIsValid($value);
        $this->value = $value;
    }

    abstract protected function assertValueIsValid(string $value): void;

    public function value(): string
    {
        return $this->value;
    }

    public function equals(mixed $object): bool
    {
        if (!$object instanceof static) {
            return false;
        }

        return $object->value() === $this->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }


    protected function assertValueIsNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new DomainException(
                sprintf(self::ERROR_IS_EMPTY, $this->name())
            );
        }
    }

    protected function assertValueIsNotTooShort(string $value, int $minLength): void
    {
        if (strlen($value) < $minLength) {
            throw new DomainException(
                sprintf(self::ERROR_TOO_SHORT, $this->name(), $minLength)
            );
        }
    }

    protected function assertValueIsNotTooLong(string $value, int $maxLength): void
    {
        if (strlen($value) > $maxLength) {
            throw new DomainException(
                sprintf(self::ERROR_TOO_LONG, $this->name(), $maxLength)
            );
        }
    }

    protected function assertValueIsUuid(string $value): void
    {
        if (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $value) === 0) {
            throw new DomainException(
                sprintf(self::ERROR_NOT_UUID, $this->name())
            );
        }
    }
}
