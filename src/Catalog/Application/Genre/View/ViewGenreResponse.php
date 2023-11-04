<?php

namespace Bookshop\Catalog\Application\Genre\View;

use Bookshop\Catalog\Domain\Genre\Genre;

class ViewGenreResponse
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
