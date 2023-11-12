<?php

namespace Bookshop\Catalog\Domain\Genre;

use DomainException;

class GenreName
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertIsValidName($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assertIsValidName(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('Genre name cannot be empty');
        } else if (strlen($value) > 255) {
            throw new DomainException('Genre name cannot be longer than 255 characters');
        } else if (strlen($value) < 3) {
            throw new DomainException('Genre name cannot be shorter than 3 characters');
        }
    }
}
