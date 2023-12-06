<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use InvalidArgumentException;

final class BookId
{
    private const ERROR_EMPTY = 'Book id cannot be empty';

    private string $value;

    public static function create(): self
    {
        return new self(uniqid());
    }

    public function __construct(string $value)
    {
        $this->assertValueIsValid($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    protected function assertValueIsValid(string $value): void
    {
        if (empty($value)) {
            throw new InvalidArgumentException(self::ERROR_EMPTY);
        }
    }
}
