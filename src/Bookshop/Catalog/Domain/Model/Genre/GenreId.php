<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;

class GenreId
{
    private const ERROR_EMPTY = 'Genre id cannot be empty';

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

    private function assertValueIsValid(string $value): void
    {
        if (empty($value)) {
            throw new DomainException(self::ERROR_EMPTY);
        }
    }
}
