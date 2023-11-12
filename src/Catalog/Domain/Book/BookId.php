<?php

namespace Bookshop\Catalog\Domain\Book;

use DomainException;

class BookId
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertIsValidId($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assertIsValidId(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('Book id cannot be empty');
        } else if (strlen($value) > 36) {
            throw new DomainException('Book id cannot be longer than 36 characters');
        } else if (strlen($value) < 36) {
            throw new DomainException('Book id cannot be shorter than 36 characters');
        }
    }
}
