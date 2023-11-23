<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

class Genre
{
    public function __construct(
        private GenreId $genreId,
        private GenreName $genreName,
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

    /** @return array<string,string> */
    public function toArray(): array
    {
        return [
            'id' => $this->genreId->value(),
            'name' => $this->genreName->value(),
        ];
    }
}
