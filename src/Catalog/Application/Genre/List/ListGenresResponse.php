<?php

namespace Bookshop\Catalog\Application\Genre\List;

class ListGenresResponse
{
    private array $genres;
    private int $total;

    public function __construct(array $genres, int $total)
    {
        $this->genres = $genres;
        $this->total = $total;
    }

    public function genres(): array
    {
        return $this->genres;
    }

    public function total(): int
    {
        return $this->total;
    }
}