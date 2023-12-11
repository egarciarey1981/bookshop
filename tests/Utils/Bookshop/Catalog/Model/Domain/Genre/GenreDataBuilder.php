<?php

namespace Tests\Utils\Bookshop\Catalog\Model\Domain\Genre;

use Bookshop\Catalog\Domain\Model\Genre\Genre;
use Bookshop\Catalog\Domain\Model\Genre\GenreId;
use Bookshop\Catalog\Domain\Model\Genre\GenreName;
use Bookshop\Catalog\Domain\Model\Genre\GenreNumberOfBooks;

class GenreDataBuilder
{
    private GenreId $genreId;
    private GenreName $genreName;
    private GenreNumberOfBooks $genreNumberOfBooks;

    public function __construct()
    {
        $genreObjectMother = GenreObjectMother::createOne();

        $this->genreId = $genreObjectMother->genreId();
        $this->genreName = $genreObjectMother->genreName();
        $this->genreNumberOfBooks = $genreObjectMother->genreNumberOfBooks();
    }

    public function withGenreId(GenreId $genreId): self
    {
        $this->genreId = $genreId;
        return $this;
    }

    public function withGenreName(GenreName $genreName): self
    {
        $this->genreName = $genreName;
        return $this;
    }

    public function withGenreNumberOfBooks(GenreNumberOfBooks $genreNumberOfBooks): self
    {
        $this->genreNumberOfBooks = $genreNumberOfBooks;
        return $this;
    }

    public function build(): Genre
    {
        return new Genre(
            $this->genreId,
            $this->genreName,
            $this->genreNumberOfBooks,
        );
    }
}
