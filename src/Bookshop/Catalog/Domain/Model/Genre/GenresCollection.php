<?php

namespace Bookshop\Catalog\Domain\Model\Genre;

use Iterator;

class GenresCollection implements Iterator
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

    public function current(): Genre
    {
        return current($this->genres);
    }

    public function next(): void
    {
        next($this->genres);
    }

    public function key(): ?int
    {
        return key($this->genres);
    }

    public function valid(): bool
    {
        return key($this->genres) !== null;
    }

    public function rewind(): void
    {
        reset($this->genres);
    }
}
