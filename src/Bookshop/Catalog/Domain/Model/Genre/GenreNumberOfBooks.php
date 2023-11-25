<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\ValueObject\IntegerValueObject;

final class GenreNumberOfBooks extends IntegerValueObject
{
    public function __construct(int $value = 0)
    {
        $this->assertValueIsValid($value);
        $this->value = $value;
    }

    protected function name(): string
    {
        return 'Genre Number Of Books';
    }

    public static function create(?int $value = null): self
    {
        if (is_null($value)) {
            $value = 0;
        }
        return new static($value);
    }

    protected function assertValueIsValid(int $value): void
    {
        $this->assertValueIsPositive($value);
    }
}
