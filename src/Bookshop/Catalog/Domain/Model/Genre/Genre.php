<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

class Genre
{
    public function __construct(
        private GenreId $genreId,
        private GenreName $genreName,
        private int $numberOfBooks = 0,
    ) {
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }

    public function numberOfBooks(): int
    {
        return $this->numberOfBooks;
    }

    /** @return array<string,string> */
    public function toArray(): array
    {
        return [
            'id' => $this->genreId->value(),
            'name' => $this->genreName->value(),
            'number_of_books' => (string) $this->numberOfBooks,
        ];
    }
}
