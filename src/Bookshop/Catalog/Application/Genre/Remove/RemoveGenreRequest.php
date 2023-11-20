<?php

namespace Bookshop\Catalog\Application\Genre\Remove;

class RemoveGenreRequest
{
    private string $genreId;

    public function __construct(string $genreId)
    {
        $this->genreId = $genreId;
    }

    public function genreId(): string
    {
        return $this->genreId;
    }
}
