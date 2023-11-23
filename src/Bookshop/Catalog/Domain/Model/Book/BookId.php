<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use DomainException;

class BookId
{
    public function __construct(private string $value)
    {
        $this->assertIsValidId($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assertIsValidId(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('Book id cannot be empty');
        } elseif (strlen($value) > 255) {
            throw new DomainException('Book id cannot be longer than 255 characters');
        } elseif (strlen($value) < 3) {
            throw new DomainException('Book id cannot be shorter than 3 characters');
        }
    }
}
