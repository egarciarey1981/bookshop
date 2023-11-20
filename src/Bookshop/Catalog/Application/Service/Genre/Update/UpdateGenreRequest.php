<?php

namespace Bookshop\Catalog\Application\Service\Genre\Update;

class UpdateGenreRequest
{
    private string $genreId;
    private string $genreName;

    public function __construct(string $genreId, string $genreName)
    {
        $this->genreId = $genreId;
        $this->genreName = $genreName;
    }

    public function genreId(): string
    {
        return $this->genreId;
    }

    public function genreName(): string
    {
        return $this->genreName;
    }
}
