<?php

namespace Tests\Unit\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use PHPUnit\Framework\TestCase;

class GenreNumberOfBooksTest extends TestCase
{
    private const MIN_LENGTH = 0;

    public function testCheckValueEmpty(): void
    {
        $this->expectException(DomainException::class);
        new GenreNumberOfBooks(self::MIN_LENGTH - 1);
    }

    public function testCheckValueEnoughShort(): void
    {
        $genre = new GenreNumberOfBooks(self::MIN_LENGTH);
        $this->assertEquals(self::MIN_LENGTH, $genre->value());
    }
}
