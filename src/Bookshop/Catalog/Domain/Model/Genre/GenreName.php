<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\ValueObject\StringValueObject;

final class GenreName extends StringValueObject
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    protected function name(): string
    {
        return 'Genre name';
    }

    protected function assertValueIsValid(string $value): void
    {
        $this->assertValueIsNotEmpty($value);
        $this->assertValueIsNotTooShort($value, self::MIN_LENGTH);
        $this->assertValueIsNotTooLong($value, self::MAX_LENGTH);
    }
}
