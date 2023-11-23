<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;

class GenreName
{
    public function __construct(private string $value)
    {
        $this->assertIsValidName($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assertIsValidName(string $value): void
    {
        if (empty($value)) {
            throw new DomainException('Genre name cannot be empty');
        } elseif (strlen($value) > 255) {
            throw new DomainException('Genre name cannot be longer than 255 characters');
        } elseif (strlen($value) < 3) {
            throw new DomainException('Genre name cannot be shorter than 3 characters');
        }
    }
}
