<?php

namespace Bookshop\Catalog\Domain\Model\Book;

use Bookshop\Catalog\Domain\ValueObject\StringValueObject;

final class BookId extends StringValueObject
{
    protected function name(): string
    {
        return 'Book ID';
    }

    protected function assertValueIsValid(string $value): void
    {
        $this->assertValueIsNotEmpty($value);
        $this->assertValueIsUuid($value);
    }
}
