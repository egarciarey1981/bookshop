<?php

namespace Test\Unit\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use PHPUnit\Framework\TestCase;

class GenreNameTest extends TestCase
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 255;

    public function testCreate(): void
    {
        $genreName = new GenreName('Genre name');
        $this->assertEquals('Genre name', $genreName->value());
    }

    public function testCheckValueEmpty(): void
    {
        $this->expectException(DomainException::class);
        new GenreName('');
    }

    public function testCheckValueEnoughShort(): void
    {
        $value = str_repeat('a', self::MIN_LENGTH);
        $genre = new GenreName($value);
        $this->assertEquals($value, $genre->value());
    }

    public function testCheckValueEnoughLong(): void
    {
        $value = str_repeat('a', self::MAX_LENGTH);
        $genre = new GenreName($value);
        $this->assertEquals($value, $genre->value());
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
