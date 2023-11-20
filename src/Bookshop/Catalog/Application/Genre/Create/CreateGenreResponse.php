<?php

namespace Bookshop\Catalog\Application\Genre\Create;

class CreateGenreResponse
{
    private array $genre;

    public function __construct(array $genre)
    {
        $this->genre = $genre;
    }

    public function genre(): array
    {
        return $this->genre;
    }
}
