<?php

namespace Bookshop\Catalog\Domain\Genre;

class Genre
{
    private GenreId $genreId;
    private GenreName $genreName;

    public function __construct(GenreId $genreId, GenreName $genreName)
    {
        $this->genreId = $genreId;
        $this->genreName = $genreName;
    }

    public function genreId(): GenreId
    {
        return $this->genreId;
    }

    public function genreName(): GenreName
    {
        return $this->genreName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->genreId->value(),
            'name' => $this->genreName->value(),
        ];
    }
}
