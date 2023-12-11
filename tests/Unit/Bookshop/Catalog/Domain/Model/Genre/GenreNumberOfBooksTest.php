<?php

namespace Test\Unit\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;
use PHPUnit\Framework\TestCase;

class GenreNumberOfBooksTest extends TestCase
{
    public function testCheckValueEmpty(): void
    {
        $this->expectException(DomainException::class);
        new GenreNumberOfBooks(-1);
    }
}
