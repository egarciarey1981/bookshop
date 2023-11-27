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

    public static function fromPrimitives(
        string $genreId,
        string $genreName,
        int $numberOfBooks,
    ): self {
        return new self(
            new GenreId($genreId),
            new GenreName($genreName),
            new GenreNumberOfBooks($numberOfBooks),
        );
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function setName(GenreName $genreName): self
    {
        return new self(
            $this->genreId,
            $genreName,
            $this->numberOfBooks,
        );
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
