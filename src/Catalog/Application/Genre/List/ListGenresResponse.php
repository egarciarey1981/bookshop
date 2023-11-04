<?php

namespace Bookshop\Catalog\Application\Genre\List;

use Bookshop\Catalog\Domain\Genre\Genre;

class ListGenresResponse
{
    private array $genres = [];

    public function __construct(Genre ...$genres)
    {
        foreach ($genres as $genre) {
            $this->genres[] = [
                'id' => $genre->id()->value(),
                'name' => $genre->name()->value(),
            ];
        }
    }

    public function genres(): array
    {
        return $this->genres;
    }
}