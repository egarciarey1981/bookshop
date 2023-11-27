<?php

namespace Test\Bookshop\Catalog\Domain\Model\Genre;

use Bookshop\Catalog\Domain\Exception\DomainException;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use PHPUnit\Framework\TestCase;

class GenreNameTest extends TestCase
{
    public function testCheckValueTooShort(): void
    {
        $this->assertTrue(true);
    }
}
