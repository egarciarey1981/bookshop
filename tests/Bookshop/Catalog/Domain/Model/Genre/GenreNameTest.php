<?php

namespace Test\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use PHPUnit\Framework\TestCase;

class GenreNameTest extends TestCase
{
    private const MIN_LENGTH = 3;
    private const MAX_LENGTH = 50;

    public function testCheckValueTooShort(): void
    {
        $value = str_repeat('a', self::MIN_LENGTH - 1);
        $this->expectException(DomainException::class);
        new GenreName('aa');
    }
}
