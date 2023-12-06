<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\Exception\DomainException;

class BookTitle
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    private const ERROR_EMPTY = 'Book title cannot be empty';
    private const ERROR_TOO_SHORT = 'Book title cannot be shorter than %d characters';
    private const ERROR_TOO_LONG = 'Book title cannot be longer than %d characters';

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
            throw new DomainException(self::ERROR_EMPTY);
        } elseif (strlen($value) < self::MIN_LENGTH) {
            throw new DomainException(sprintf(self::ERROR_TOO_SHORT, self::MIN_LENGTH));
        } elseif (strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(sprintf(self::ERROR_TOO_LONG, self::MAX_LENGTH));
        }
    }
}
