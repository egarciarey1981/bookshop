<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;

class GenreNumberOfBooks
{
    private const ERROR_MESSAGE = 'Genre number of books cannot be negative';

    private int $value;

    public function __construct(int $value)
    {
        $this->assertValueIsValid($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    private function assertValueIsValid(int $value): void
    {
        if ($value < 0) {
            throw new DomainException(self::ERROR_MESSAGE);
        }
    }

    public function equals(self $genreNumberOfBooks): bool
    {
        return $this->value() === $genreNumberOfBooks->value();
    }
}
