<?php

namespace Bookshop\Catalog\Application\Genre\View;

class ViewGenreResponse
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
