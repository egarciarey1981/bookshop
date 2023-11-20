<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use DomainException;

class BookTitle
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertIsValidTitle($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assertIsValidTitle(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('Book title cannot be empty');
        } elseif (strlen($value) > 255) {
            throw new DomainException('Book title cannot be longer than 255 characters');
        } elseif (strlen($value) < 3) {
            throw new DomainException('Book title cannot be shorter than 3 characters');
        }
    }
}
