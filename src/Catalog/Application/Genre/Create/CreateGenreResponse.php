<?php

namespace Bookshop\Catalog\Application\Genre\Create;

use Bookshop\Catalog\Domain\Genre\Genre;

class CreateGenreResponse
{
    private array $genre = [];

    public function __construct(Genre $genre)
    {
        $this->genre = [
            'id' => $genre->id()->value(),
            'name' => $genre->name()->value(),
        ];
    }

    public function genre(): array
    {
        return $this->genre;
    }
}
