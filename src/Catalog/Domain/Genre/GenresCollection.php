<?php

namespace Bookshop\Catalog\Domain\Genre;

class GenresCollection
{
    private array $genres = [];

    public function __construct(...$genres)
    {
        $this->genres = $genres;
    }

    public function contains(Genre $genre): bool
    {
        return in_array($genre, $this->genres);
    }

    public function genres(): array
    {
        return $this->genres;
    }

    public function toArray(): array
    {
        return array_map(
            fn (Genre $genre) => $genre->toArray(),
            $this->genres
        );
    }
}
