<?php

namespace Bookshop\Catalog\Application\Service\Genre\Create;

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
