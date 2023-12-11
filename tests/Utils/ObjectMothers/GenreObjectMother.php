<?php

namespace Tests\Utils\ObjectMothers;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;

class GenreObjectMother
{
    public static function createOne(): Genre
    {
        return new Genre(
            GenreId::create(),
            new GenreName('Adventure'),
            new GenreNumberOfBooks(10),
        );
    }
}
