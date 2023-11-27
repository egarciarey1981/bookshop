<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

class Genre
{
    private GenreId $genreId;
    private GenreName $genreName;
    private GenreNumberOfBooks $numberOfBooks;

    public function __construct(
        GenreId $genreId,
        GenreName $genreName,
        GenreNumberOfBooks $numberOfBooks,
    ) {
        $this->genreId = $genreId;
        $this->genreName = $genreName;
        $this->numberOfBooks = $numberOfBooks;
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }

    public function numberOfBooks(): GenreNumberOfBooks
    {
        return $this->numberOfBooks;
    }
}
