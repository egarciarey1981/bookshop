<?php

namespace Bookshop\Catalog\Application\Genre\List;

class ListGenresResponse
{
    private array $genres;

    public function __construct(array $genres)
    {
        $this->genres = $genres;
    }

    public function genres(): array
    {
        return $this->genres;
    }
}