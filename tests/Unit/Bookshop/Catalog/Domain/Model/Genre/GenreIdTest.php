<?php

namespace Test\Unit\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use PHPUnit\Framework\TestCase;

class GenreIdTest extends TestCase
{
    public function testCheckValueEmpty(): void
    {
        $this->expectException(DomainException::class);
        new GenreId('');
    }
}
