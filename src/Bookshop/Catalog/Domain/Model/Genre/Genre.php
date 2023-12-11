<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

class Genre
{
    private GenreId $genreId;
    private GenreName $genreName;
    private GenreNumberOfBooks $genreNumberOfBooks;

    public function __construct(
        GenreId $genreId,
        GenreName $genreName,
        GenreNumberOfBooks $genreNumberOfBooks,
    ) {
        $this->genreId = $genreId;
        $this->genreName = $genreName;
        $this->genreNumberOfBooks = $genreNumberOfBooks;
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }

    public function genreNumberOfBooks(): GenreNumberOfBooks
    {
        return $this->genreNumberOfBooks;
    }
}
