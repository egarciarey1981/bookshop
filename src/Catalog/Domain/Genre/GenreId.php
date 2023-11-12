<?php

namespace Bookshop\Catalog\Domain\Genre;

use DomainException;

class GenreId
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
            throw new DomainException('Genre id cannot be empty');
        } elseif (strlen($value) > 36) {
            throw new DomainException('Genre id cannot be longer than 36 characters');
        } elseif (strlen($value) < 36) {
            throw new DomainException('Genre id cannot be shorter than 36 characters');
        }
    }
}
