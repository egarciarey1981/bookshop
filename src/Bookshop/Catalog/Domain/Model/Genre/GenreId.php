<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\ValueObject\StringValueObject;

final class GenreId extends StringValueObject
{
    protected function name(): string
    {
        return 'Genre ID';
    }

    protected function assertValueIsValid(string $value): void
    {
        $this->assertValueIsNotEmpty($value);
        $this->assertValueIsUuid($value);
    }
}
