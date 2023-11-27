<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use InvalidArgumentException;

final class GenreId
{
    private string $value;

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
            throw new InvalidArgumentException('Genre id cannot be empty');
        }
    }
}
