<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\Exception\DomainException;

class BookTitle
{
    public function __construct(private string $value)
    {
        $this->assertIsValidTitle($value);
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
