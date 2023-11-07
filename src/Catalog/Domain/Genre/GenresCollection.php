<?php

namespace Bookshop\Catalog\Domain\Genre;

class GenresCollection
{
    private array $genres = [];

    public function contains(Genre $genre): bool
    {
        return in_array($genre, $this->genres);
    }

    public function add(Genre $genre): void
    {
        if (!$this->contains($genre)) {
            $this->genres[] = $genre;
        }            
    }

    public function genres(): array
    {
        return $this->genres;
    }
}
