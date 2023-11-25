<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\ValueObject\StringValueObject;

final class BookTitle extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    protected function name(): string
    {
        return 'Book title';
    }

    protected function assertValueIsValid(string $value): void
    {
        $this->assertValueIsNotEmpty($value);
        $this->assertValueIsNotTooShort($value, self::MIN_LENGTH);
        $this->assertValueIsNotTooLong($value, self::MAX_LENGTH);
    }
}
