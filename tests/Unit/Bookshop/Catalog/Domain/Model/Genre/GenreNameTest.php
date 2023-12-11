<?php

namespace Test\Unit\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use PHPUnit\Framework\TestCase;

class GenreNameTest extends TestCase
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    public function testCheckValueEmpty(): void
    {
        $this->expectException(DomainException::class);
        new GenreName('');
    }

    public function testCheckValueTooShort(): void
    {
        $this->expectException(DomainException::class);
        $value =  str_repeat('a', self::MIN_LENGTH - 1);
        new GenreName($value);
    }

    public function testCheckValueTooLong(): void
    {
        $this->expectException(DomainException::class);
        $value = str_repeat('a', self::MAX_LENGTH + 1);
        new GenreName($value);
    }
}
